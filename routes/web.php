<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

// Debug routes
Route::get('/debug/products', function() {
    $products = \App\Models\Product::all();
    return response()->json([
        'total' => $products->count(),
        'products' => $products->take(5)->toArray()
    ]);
});

Route::get('/debug/available', function() {
    $available = \App\Models\Product::where('available', true)->get();
    $unavailable = \App\Models\Product::where('available', false)->get();
    return response()->json([
        'total_available' => $available->count(),
        'total_unavailable' => $unavailable->count(),
        'available_products' => $available->take(5)->toArray(),
        'unavailable_products' => $unavailable->take(5)->toArray()
    ]);
});

Route::get('/debug/products/view', function() {
    $products = \App\Models\Product::paginate(12);
    return view('products.debug', compact('products'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'otp_verified'])->name('dashboard'); // Using the new middleware without dot

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Authentication required routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Checkout route
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    
    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Payment routes
    Route::get('/payment/{id}/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    
    // Test VNPAY route
    Route::get('/test-vnpay', function () {
        $vnp_TmnCode = env('VNPAY_TMN_CODE');
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $vnp_Url = env('VNPAY_URL');
        $vnp_ReturnUrl = url('/payment/callback');
        
        $vnp_TxnRef = "TEST" . time();
        $vnp_OrderInfo = "Test VNPAY Payment";
        $vnp_Amount = 10000000; // 100,000 VND
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => request()->ip(),
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        ksort($inputData);
        $query = "";
        $hashdata = "";
        $i = 0;
        
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
        $finalUrl = $vnp_Url . "?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;
        
        return redirect($finalUrl);
    })->name('test.vnpay');
    
    // Test login route
    Route::get('/test-login', function () {
        $user = \App\Models\User::where('email', 'test@example.com')->first();
        if ($user) {
            auth()->login($user);
            return redirect('/payment/7/process')->with('success', 'Logged in as test user');
        }
        return redirect('/login')->with('error', 'Test user not found');
    })->name('test.login');
    
    // Test payment route for debugging
    Route::get('/test-payment', function() {
        // Create a fake test order for payment testing
        $user = auth()->user();
        if (!$user) {
            return redirect('/test-login');
        }
        
        // Create or find a test order
        $testOrder = \App\Models\Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        
        if (!$testOrder) {
            $testOrder = new \App\Models\Order();
            $testOrder->user_id = $user->id;
            $testOrder->total_price = 27.30; // Test amount
            $testOrder->status = 'pending';
            $testOrder->payment_method = 'vnpay';
            $testOrder->save();
        }
        
        return redirect()->route('payment.process', $testOrder->id);
    })->middleware('auth');
});

// Debug route để test VNPAY trực tiếp
Route::get('/debug-vnpay', function() {
    echo "<h2>VNPAY Debug Test</h2>";
    
    // Test với demo credentials
    $vnp_TmnCode = "2QXUI4J4";
    $vnp_HashSecret = "RAOEXHYVSDDIBLCELLK3TMMU2ATMTTJYCPKCJLYE2IMQAC";
    
    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => "1000000", // 10,000 VND
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => "127.0.0.1",
        "vnp_Locale" => "vn",
        "vnp_OrderInfo" => "Debug Test",
        "vnp_OrderType" => "billpayment",
        "vnp_ReturnUrl" => "http://localhost:8000/payment/callback",
        "vnp_TxnRef" => "DEBUG" . time()
    );
    
    ksort($inputData);
    
    echo "<h3>Input Data:</h3><pre>";
    print_r($inputData);
    echo "</pre>";
    
    // Generate hash
    $hashdata = "";
    $i = 0;
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }
    
    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    
    echo "<h3>Hash Data:</h3><p>" . htmlspecialchars($hashdata) . "</p>";
    echo "<h3>Hash Secret:</h3><p>" . $vnp_HashSecret . "</p>";
    echo "<h3>Generated Hash:</h3><p>" . $vnpSecureHash . "</p>";
    
    // Generate URL
    $query = "";
    foreach ($inputData as $key => $value) {
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }
    
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;
    
    echo "<h3>Final URL:</h3>";
    echo "<p><a href='" . $vnp_Url . "' target='_blank'>Test Payment URL</a></p>";
    echo "<p><small>" . htmlspecialchars($vnp_Url) . "</small></p>";
    
    echo "<h3>Instructions:</h3>";
    echo "<p>1. Click the link above to test payment</p>";
    echo "<p>2. Should redirect to VNPAY page without 'Sai chữ ký' error</p>";
    echo "<p>3. Timeout error is normal for demo account</p>";
});

// Admin routes
Route::middleware([
    \App\Http\Middleware\Authenticate::class,
    \App\Http\Middleware\EnsureOtpVerified::class,
    \App\Http\Middleware\AdminMiddleware::class
])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Admin product routes
    Route::resource('products', AdminProductController::class);
    
    // Admin user routes
    Route::resource('users', AdminUserController::class);
    Route::post('/users/{id}/toggle-verification', [AdminUserController::class, 'toggleVerification'])->name('users.toggle-verification');
    
    // Admin order routes
    Route::resource('orders', AdminOrderController::class);
});

// VNPAY Return và IPN URLs
Route::get('/vnpay/return', [PaymentController::class, 'vnpayReturn'])->name('vnpay.return');
Route::get('/vnpay/ipn', [PaymentController::class, 'vnpayIpn'])->name('vnpay.ipn');

require __DIR__.'/auth.php';
