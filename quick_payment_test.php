<?php
/**
 * QUICK PAYMENT TEST SCRIPT
 * 
 * This script creates a test order and generates a payment URL for testing
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h1>🚀 QUICK PAYMENT TEST</h1>";
echo "<p><strong>Date:</strong> " . date('Y-m-d H:i:s') . "</p>";

try {
    // Find a user (assuming user ID 2 exists)
    $user = App\Models\User::find(2);
    if (!$user) {
        echo "<p style='color: red;'>❌ User ID 2 not found. Please check your users table.</p>";
        exit;
    }

    // Create a test order
    $order = new App\Models\Order();
    $order->user_id = $user->id;
    $order->total_price = 9.99; // $9.99 USD
    $order->payment_method = 'vnpay';
    $order->status = 'pending';
    $order->save();

    echo "<div style='background: #d4edda; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>✅ Test Order Created</h3>";
    echo "<ul>";
    echo "<li><strong>Order ID:</strong> " . $order->id . "</li>";
    echo "<li><strong>User:</strong> " . $user->name . " (" . $user->email . ")</li>";
    echo "<li><strong>Amount:</strong> $" . number_format($order->total_price, 2) . " USD</li>";
    echo "<li><strong>Status:</strong> " . $order->status . "</li>";
    echo "</ul>";
    echo "</div>";

    // Generate payment URL
    $vnp_TmnCode = "1VYBIYQP";
    $vnp_HashSecret = "NOH6MBGNLQL9O9OMMFMZ2AX8NIEP50W1";
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://localhost:8000/vnpay/return";

    $vnp_TxnRef = $order->id;
    $vnp_OrderInfo = 'Thanh toan GD:' . $vnp_TxnRef;
    $vnp_Amount = (int) round($order->total_price * 24000 * 100); // USD to VND * 100

    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => "127.0.0.1",
        "vnp_Locale" => "vn",
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => "other",
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
        "vnp_ExpireDate" => date('YmdHis', strtotime('+15 minutes'))
    );

    ksort($inputData);

    // Build hash
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
    }

    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $paymentUrl = $vnp_Url . "?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;

    echo "<div style='background: #e7f3ff; padding: 15px; border: 1px solid #b3d9ff; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>💳 Payment URL Generated</h3>";
    echo "<p><strong>Amount (VND):</strong> " . number_format($vnp_Amount) . " (= $" . $order->total_price . " USD)</p>";
    echo "<p><strong>Transaction Ref:</strong> " . $vnp_TxnRef . "</p>";
    echo "<p><strong>Test Payment URL:</strong></p>";
    echo "<a href='" . $paymentUrl . "' target='_blank' style='display: inline-block; background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 10px 0;'>🚀 PAY NOW (Test)</a>";
    echo "</div>";

    echo "<div style='background: #fff3cd; padding: 15px; border: 1px solid #ffeaa7; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>📋 Testing Steps</h3>";
    echo "<ol>";
    echo "<li>Click the 'PAY NOW' button above</li>";
    echo "<li>Complete payment on VNPAY sandbox</li>";
    echo "<li>Should redirect back to order page with success message</li>";
    echo "<li>Order status should change to 'paid'</li>";
    echo "<li>Pay Now button should disappear</li>";
    echo "</ol>";
    echo "</div>";

    echo "<div style='background: #f8f9fa; padding: 15px; border: 1px solid #dee2e6; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>🔗 Quick Links</h3>";
    echo "<ul>";
    echo "<li><a href='http://localhost:8000/orders/" . $order->id . "' target='_blank'>View Order Details</a></li>";
    echo "<li><a href='http://localhost:8000/orders' target='_blank'>All Orders</a></li>";
    echo "<li><a href='http://localhost:8000' target='_blank'>Laravel App</a></li>";
    echo "</ul>";
    echo "</div>";

} catch (Exception $e) {
    echo "<div style='background: #f8d7da; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>❌ Error</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}
?>
