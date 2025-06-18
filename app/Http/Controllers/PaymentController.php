<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{    public function process(string $id)
    {
        // Set Vietnam timezone for correct time
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->findOrFail($id);
        
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'This order cannot be paid!');
        }        
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8000/vnpay/return";        // VNPAY Official Credentials - TEMPORARILY REVERT TO WORKING ACCOUNT
        $vnp_TmnCode = "1VYBIYQP";
        $vnp_HashSecret = "NOH6MBGNLQL9O9OMMFMZ2AX8NIEP50W1";
          $vnp_TxnRef = $order->id;
        $vnp_OrderInfo = 'Thanh toan GD:' . $vnp_TxnRef; // EXACTLY like VNPAY demo
        $vnp_OrderType = 'other'; // Like VNPAY demo (not 'billpayment')
          // Convert USD to VND (assuming 1 USD = 24,000 VND)
        $usdToVnd = 24000;
        // Ensure amount is ALWAYS an integer (no decimals) - simplified method
        $vnp_Amount = (int) round($order->total_price * $usdToVnd * 100);        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = '127.0.0.1'; // Force IPv4

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,            "vnp_ExpireDate" => date('YmdHis', strtotime('+15 minutes')) // Like VNPAY demo
        );

        // Remove empty values
        $inputData = array_filter($inputData, function($value) {
            return $value !== '' && $value !== null;
        });

        ksort($inputData);        // Build hash data string - EXACTLY like VNPAY official demo
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }        // Generate secure hash - EXACTLY like VNPAY official demo
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        
        // Build final URL - EXACTLY like VNPAY official demo  
        $vnp_Url = $vnp_Url . "?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;Log::info('VNPAY Payment Debug - COMPLETE WITH vnp_ExpireDate', [
            'order_id' => $order->id,
            'amount_usd_original' => $order->total_price,
            'amount_vnd_calculation' => ($order->total_price * $usdToVnd * 100),
            'amount_vnd_final_integer' => $vnp_Amount,
            'conversion_rate' => $usdToVnd,
            'input_data' => $inputData,
            'hashdata_url_encoded' => $hashdata,
            'hashdata_length' => strlen($hashdata),
            'secure_hash' => $vnpSecureHash ?? 'N/A',
            'url_length' => strlen($vnp_Url),
            'return_url' => $vnp_Returnurl,
            'method' => 'COMPLETE_WITH_EXPIRE_DATE',
            'tmn_code' => $vnp_TmnCode,
            'hash_secret_length' => strlen($vnp_HashSecret),
            'expire_date' => $inputData['vnp_ExpireDate'] ?? 'N/A'
        ]);

        return redirect($vnp_Url);
    }    public function callback(Request $request)
    {
        $vnp_HashSecret = "NOH6MBGNLQL9O9OMMFMZ2AX8NIEP50W1";
        
        $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = array();
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value); // URL encode for hash verification (back to original method)
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value); // URL encode for hash verification (back to original method)
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        
        // Extract order ID from transaction reference
        $txnRef = $request->vnp_TxnRef;
        $orderId = (int) preg_replace('/[^0-9]/', '', $txnRef);
        $order = Order::find($orderId);
        
        Log::info('VNPAY Callback', [
            'response_code' => $request->vnp_ResponseCode,
            'txn_ref' => $txnRef,
            'order_id' => $orderId,
            'hash_valid' => ($secureHash == $vnp_SecureHash),
            'amount' => $request->vnp_Amount ?? 0
        ]);
        
        if (!$order) {
            return view('payment.result')->with('error', 'Order not found!');
        }

        if ($secureHash == $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                $order->status = 'paid';
                $order->save();
                return view('payment.result')->with('success', 'Payment successful! Your order has been processed.');
            } else {
                return view('payment.result')->with('error', 'Payment failed! Error code: ' . $request->vnp_ResponseCode);
            }
        } else {
            return view('payment.result')->with('error', 'Invalid signature! Security check failed.');
        }
    }

    /**
     * VNPAY Return URL handler
     * Xử lý khi khách hàng được chuyển về từ VNPAY
     */    public function vnpayReturn(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        // Credentials - TEMPORARILY REVERT TO WORKING ACCOUNT
        $vnp_HashSecret = "NOH6MBGNLQL9O9OMMFMZ2AX8NIEP50W1";
        
        // Get all vnp_ parameters
        $inputData = array();
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
          // Build hash data - EXACTLY like VNPAY official demo
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        
        Log::info('VNPAY Return', [
            'response_code' => $request->vnp_ResponseCode,
            'txn_ref' => $request->vnp_TxnRef,
            'hash_valid' => ($secureHash == $vnp_SecureHash),
            'amount' => $request->vnp_Amount ?? 0,
            'hash_data' => $hashData,
            'all_params' => $inputData
        ]);        // Display result to customer AND update database if successful
        if ($secureHash == $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                // Update order status immediately for user feedback
                $orderId = $request->vnp_TxnRef;
                $order = Order::find($orderId);
                
                if ($order && $order->status === 'pending') {
                    $order->status = 'paid';
                    $order->save();
                    Log::info('VNPAY Return - Order updated to PAID', ['order_id' => $orderId]);
                }
                
                return redirect()->route('orders.show', $orderId)
                    ->with('success', 'Thanh toán thành công! Đơn hàng đã được xử lý.');
            } else {
                $orderId = $request->vnp_TxnRef;
                return redirect()->route('orders.show', $orderId)
                    ->with('error', 'Thanh toán thất bại! Mã lỗi: ' . $request->vnp_ResponseCode);
            }
        } else {
            return view('payment.result')->with('error', 'Chữ ký không hợp lệ! Kiểm tra bảo mật thất bại.');
        }
    }

    /**
     * VNPAY IPN URL handler
     * Xử lý thông báo từ VNPAY (server-to-server)
     */    public function vnpayIpn(Request $request)
    {        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        // Credentials - TEMPORARILY REVERT TO WORKING ACCOUNT
        $vnp_HashSecret = "NOH6MBGNLQL9O9OMMFMZ2AX8NIEP50W1";
        
        $inputData = array();
        $returnData = array();
        
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
          // Build hash data - EXACTLY like VNPAY official demo  
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount']/100; // Số tiền thanh toán VNPAY phản hồi

        $orderId = $inputData['vnp_TxnRef'];

        Log::info('VNPAY IPN', [
            'vnp_ResponseCode' => $inputData['vnp_ResponseCode'],
            'vnp_TransactionStatus' => $inputData['vnp_TransactionStatus'],
            'vnp_TransactionNo' => $vnpTranId,
            'vnp_BankCode' => $vnp_BankCode,
            'vnp_Amount' => $vnp_Amount,
            'order_id' => $orderId,
            'hash_valid' => ($secureHash == $vnp_SecureHash),
            'hash_data' => $hashData,
            'all_params' => $inputData
        ]);

        try {
            //Check checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng và kiểm tra trạng thái của đơn hàng
                $order = Order::find($orderId);
                  if ($order != NULL) {
                    // Calculate expected amount: USD * 24000 (VND rate) * 100 (VNPAY format)
                    $expectedAmount = (int) round($order->total_price * 24000 * 100);
                    $receivedAmount = (int) $inputData['vnp_Amount']; // Already in cents
                    
                    Log::info('VNPAY IPN Amount Check', [
                        'order_total_usd' => $order->total_price,
                        'expected_amount_vnp' => $expectedAmount,
                        'received_amount_vnp' => $receivedAmount,
                        'amounts_match' => ($expectedAmount == $receivedAmount)
                    ]);
                    
                    //Kiểm tra số tiền thanh toán của giao dịch
                    if ($expectedAmount == $receivedAmount) {
                        if ($order["status"] == 'pending') {
                            if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                                $order->status = 'paid';
                                $order->save();
                                
                                Log::info('VNPAY IPN - Order updated to PAID', ['order_id' => $orderId]);
                            } else {
                                $order->status = 'failed';
                                $order->save();
                                
                                Log::info('VNPAY IPN - Order updated to FAILED', ['order_id' => $orderId]);
                            }
                            
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    }
                    else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
            
            Log::error('VNPAY IPN Exception', [
                'message' => $e->getMessage(),
                'order_id' => $orderId ?? 'unknown'
            ]);
        }
        
        //Trả lại VNPAY theo định dạng JSON
        return response()->json($returnData);
    }
}
