<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .content {
            padding: 30px 20px;
            background-color: #ffffff;
        }
        .code-container {
            text-align: center;
            margin: 30px 0;
        }
        .otp-code {
            display: inline-block;
            padding: 15px 30px;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #212529;
            background-color: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #dee2e6;
        }
        .expire-text {
            text-align: center;
            font-size: 14px;
            color: #777777;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #777777;
            border-top: 1px solid #eeeeee;
            margin-top: 30px;
        }
        .brand {
            font-weight: bold;
            color: #212529;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #212529; margin: 0;">
                <span style="color: #ffc107;">Burger</span> Shop
            </h1>
        </div>
        
        <div class="content">
            <h2>Hello, {{ $name }}!</h2>
            
            <p>Thank you for signing up with Burger Shop. To complete your registration and verify your account, please use the following OTP code:</p>
            
            <div class="code-container">
                <div class="otp-code">{{ $code }}</div>
            </div>
            
            <p class="expire-text">This code will expire in 10 minutes.</p>
            
            <p>If you did not request this code, please ignore this email or contact our support team if you have any concerns.</p>
            
            <p>Thank you,<br>The Burger Shop Team</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} <span class="brand">Burger Shop</span>. All rights reserved.</p>
            <p>123 Burger Street, Food City</p>
        </div>
    </div>
</body>
</html>
