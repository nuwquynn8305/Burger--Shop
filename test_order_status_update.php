<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing order status update...\n";

try {
    $order = App\Models\Order::find(17);
    if ($order) {
        echo "Order found. Current status: " . $order->status . "\n";
        $order->status = 'paid';
        $order->save();
        echo "Successfully updated to: " . $order->status . "\n";
        echo "✅ Status constraint fix working!\n";
    } else {
        echo "Order not found\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
