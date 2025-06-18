<?php

return [
    /*
    |--------------------------------------------------------------------------
    | VNPAY Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your VNPAY settings for the payment integration.
    |
    */    'tmn_code' => env('VNPAY_TMN_CODE', ''),
    'hash_secret' => env('VNPAY_HASH_SECRET', ''),
    'url' => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    'return_url' => env('VNPAY_RETURN_URL', '/payment/callback'),
    'locale' => env('VNPAY_LOCALE', 'vn'),
    'currency' => env('VNPAY_CURRENCY', 'VND'),
    'version' => '2.1.0',
    
    // Test card information
    'test_card' => [
        'bank' => 'NCB',
        'card_number' => '9704198526191432198',
        'card_holder' => 'NGUYEN VAN A',
        'expiry_date' => '07/15',
        'otp' => '123456',
    ],
];
