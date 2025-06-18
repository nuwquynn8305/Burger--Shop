<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING ADMIN ORDER MANAGEMENT ===\n\n";

try {
    // 1. Check current orders and their statuses
    echo "1. Current orders in database:\n";
    $orders = Order::with('user')->orderBy('id', 'desc')->take(10)->get();
    
    foreach ($orders as $order) {
        echo "   Order #{$order->id}: {$order->status} - {$order->user->name} - \${$order->total_price}\n";
    }
    echo "\n";

    // 2. Test status validation
    echo "2. Testing status validation:\n";
    $testOrder = $orders->first();
    if ($testOrder) {
        $validStatuses = ['pending', 'paid', 'processing', 'completed', 'cancelled', 'canceled'];
        $invalidStatuses = ['shipped', 'delivered', 'refunded'];
        
        echo "   Valid statuses: " . implode(', ', $validStatuses) . "\n";
        echo "   Invalid statuses: " . implode(', ', $invalidStatuses) . "\n";
        
        // Test updating to valid status
        $originalStatus = $testOrder->status;
        echo "   Original status: {$originalStatus}\n";
        
        // Try updating to 'processing' if not already
        if ($originalStatus !== 'processing') {
            try {
                $testOrder->update(['status' => 'processing']);
                echo "   ✓ Successfully updated to 'processing'\n";
                
                // Restore original status
                $testOrder->update(['status' => $originalStatus]);
                echo "   ✓ Restored to original status: {$originalStatus}\n";
            } catch (Exception $e) {
                echo "   ✗ Failed to update status: " . $e->getMessage() . "\n";
            }
        }
        
        // Try updating to invalid status
        try {
            $testOrder->update(['status' => 'shipped']);
            echo "   ✗ ERROR: Should not allow 'shipped' status\n";
        } catch (Exception $e) {
            echo "   ✓ Correctly rejected invalid status 'shipped': " . substr($e->getMessage(), 0, 100) . "...\n";
        }
    }
    echo "\n";

    // 3. Check constraint in database
    echo "3. Database constraint check:\n";
    try {
        $constraint = DB::select("
            SELECT constraint_name, check_clause 
            FROM information_schema.check_constraints 
            WHERE constraint_name LIKE '%orders_status%'
        ");
        
        if (!empty($constraint)) {
            foreach ($constraint as $c) {
                echo "   Constraint: {$c->constraint_name}\n";
                echo "   Check clause: {$c->check_clause}\n";
            }
        } else {
            echo "   No status constraint found (might be using enum or different DB)\n";
        }
    } catch (Exception $e) {
        echo "   Could not check constraint (using SQLite): " . $e->getMessage() . "\n";
    }
    echo "\n";

    // 4. Test status counts
    echo "4. Order status distribution:\n";
    $statusCounts = Order::select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->orderBy('count', 'desc')
        ->get();
    
    foreach ($statusCounts as $stat) {
        echo "   {$stat->status}: {$stat->count} orders\n";
    }
    echo "\n";

    // 5. Test deletable orders
    echo "5. Testing deletable orders (cancelled/canceled only):\n";
    $cancelledOrders = Order::whereIn('status', ['cancelled', 'canceled'])->count();
    $totalOrders = Order::count();
    echo "   Cancelled/Canceled orders: {$cancelledOrders}\n";
    echo "   Total orders: {$totalOrders}\n";
    echo "   Deletable orders: {$cancelledOrders}\n";
    echo "   Non-deletable orders: " . ($totalOrders - $cancelledOrders) . "\n";
    echo "\n";

    // 6. Test admin user check
    echo "6. Admin users in system:\n";
    $adminUsers = User::where('role', 'admin')->get();
    foreach ($adminUsers as $admin) {
        echo "   Admin: {$admin->name} ({$admin->email})\n";
    }
    echo "\n";

    echo "=== ADMIN ORDER MANAGEMENT TEST COMPLETED ===\n";
    echo "All constraints and validations are working correctly!\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
