<?php
/**
 * 🔧 VNPAY FIXED PAYMENT CONTROLLER - MULTIPLE HASH METHODS
 * Các phương pháp hash khác nhau để fix Error 70
 */

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentControllerFixed extends Controller
{
    private $vnp_TmnCode = "DVU7TX32";
    private $vnp_HashSecret = "L66DZSIHNTN5IQF3831WZA23H6BY2UQ3";
    private $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    private $vnp_Returnurl = "http://localhost:8000/vnpay/return";

    /**
     * Process payment with METHOD 1 (Current - URL Encoded)
     */
    public function processMethod1(string $id)
    {
        return $this->processWithMethod($id, 'method1');
    }

    /**
     * Process payment with METHOD 2 (Simple concatenation)
     */
    public function processMethod2(string $id)
    {
        return $this->processWithMethod($id, 'method2');
    }

    /**
     * Process payment with METHOD 3 (Query string style)
     */
    public function processMethod3(string $id)
    {
        return $this->processWithMethod($id, 'method3');
    }

    /**
     * Process payment with METHOD 4 (Raw values)
     */
    public function processMethod4(string $id)
    {
        return $this->processWithMethod($id, 'method4');
    }

    /**
     * Process payment with METHOD 5 (VNPAY Official Demo Style)
     */
    public function processMethod5(string $id)
    {
        return $this->processWithMethod($id, 'method5');
    }

    /**
     * Generic method to process payment with different hash methods
     */
    private function processWithMethod(string $id, string $method)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->findOrFail($id);
        
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'This order cannot be paid!');
        }

        // Convert USD to VND
        $usdToVnd = 24000;
        $vnp_Amount = (int) round($order->total_price * $usdToVnd * 100);

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => "127.0.0.1",
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => "Order " . $order->id,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $this->vnp_Returnurl,
            "vnp_TxnRef" => $order->id . time(),
            "vnp_ExpireDate" => date('YmdHis', strtotime('+30 minutes'))
        );

        // Filter and sort
        $inputData = array_filter($inputData, function($value) {
            return $value !== '' && $value !== null;
        });
        ksort($inputData);

        // Generate hash data based on method
        $hashData = $this->generateHashData($inputData, $method);
        
        // Test multiple algorithms
        $algorithms = ['sha512', 'sha256', 'md5'];
        $testUrls = [];
        
        foreach ($algorithms as $algo) {
            $hash = hash_hmac($algo, $hashData, $this->vnp_HashSecret);
            
            // Build query string
            $query = "";
            foreach ($inputData as $key => $value) {
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }
            
            $testUrl = $this->vnp_Url . "?" . $query . 'vnp_SecureHash=' . $hash;
            $testUrls[$algo] = $testUrl;
        }

        Log::info("VNPAY Payment - $method", [
            'order_id' => $order->id,
            'method' => $method,
            'hash_data' => $hashData,
            'test_urls' => $testUrls
        ]);

        // Default to SHA512 for redirect
        return redirect($testUrls['sha512']);
    }

    /**
     * Generate hash data based on different methods
     */
    private function generateHashData($inputData, $method)
    {
        $hashData = "";
        
        switch ($method) {
            case 'method1': // Current method - URL encoded with &
                $i = 0;
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashData .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                }
                break;
                
            case 'method2': // Simple concatenation
                $parts = [];
                foreach ($inputData as $key => $value) {
                    $parts[] = $key . "=" . $value;
                }
                $hashData = implode('&', $parts);
                break;
                
            case 'method3': // Query string style
                $hashData = http_build_query($inputData);
                break;
                
            case 'method4': // Raw values, no encoding
                $i = 0;
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashData .= '&' . $key . "=" . $value;
                    } else {
                        $hashData .= $key . "=" . $value;
                        $i = 1;
                    }
                }
                break;
                
            case 'method5': // VNPAY Official Demo style
                $parts = [];
                foreach ($inputData as $key => $value) {
                    $parts[] = urlencode($key) . "=" . urlencode($value);
                }
                $hashData = implode('&', $parts);
                break;
                
            default:
                $hashData = http_build_query($inputData);
        }
        
        return $hashData;
    }
}
