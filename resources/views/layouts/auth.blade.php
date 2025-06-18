<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Auth') - {{ config('app.name', 'Burger Shop') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        :root {
            --primary: #FF6B35;
            --primary-light: #FF8A5B;
            --primary-dark: #E55A2B;
            --secondary: #2C3E50;
            --accent: #F39C12;
            --dark: #1A252F;
            --light: #ECF0F1;
            --white: #FFFFFF;
            --shadow: rgba(0, 0, 0, 0.1);
            --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            --gradient-secondary: linear-gradient(135deg, var(--secondary) 0%, var(--dark) 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gradient-primary);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            z-index: -2;
        }
        
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,122.7C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') bottom/cover no-repeat;
            animation: wave 20s linear infinite;
            z-index: -1;
        }
        
        @keyframes wave {
            0% { transform: translateX(0) translateY(0); }
            50% { transform: translateX(-25px) translateY(-10px); }
            100% { transform: translateX(-50px) translateY(0); }
        }
        
        /* Auth Container */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            animation: slideInUp 0.8s ease-out;
            position: relative;
        }
        
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-primary);
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
            padding: 2rem 2rem 0;
        }
        
        .auth-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .auth-logo i {
            font-size: 2rem;
            color: var(--white);
        }
        
        .auth-title {
            font-size: 2rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }
        
        .auth-subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 0;
        }
        
        .auth-body {
            padding: 0 2rem 2rem;
        }
          /* Form Elements */
        .form-floating {
            margin-bottom: 1.5rem;
            position: relative;
        }
          .form-floating .form-control {
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(255, 107, 53, 0.1);
            border-radius: 15px;
            padding: 1rem 1rem 1rem 3.5rem;
            font-size: 1rem;
            height: auto;
            transition: all 0.3s ease;
            min-height: 58px;
        }
        
        .form-floating .form-control:focus {
            background: rgba(255, 255, 255, 0.95);
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 53, 0.1);
            transform: translateY(-2px);
        }        .form-floating .form-control:not(:placeholder-shown) {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        
        .form-floating .form-control::placeholder {
            color: #999;
            opacity: 1;
        }
        
        .form-floating .form-control:focus::placeholder {
            color: #bbb;
        }
        
        .form-floating > label {
            display: none;
        }
          /* Input Icons */
        .input-icon {
            position: absolute;
            top: 50%;
            left: 1.25rem;
            transform: translateY(-50%);
            color: var(--primary);
            z-index: 15;
            pointer-events: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        
        .form-floating:focus-within .input-icon {
            color: var(--primary-dark);
            transform: translateY(-50%) scale(1.1);
        }
        
        .form-floating .form-control:focus ~ label + .input-icon,
        .form-floating .form-control:not(:placeholder-shown) ~ label + .input-icon {
            transform: translateY(-50%) scale(0.9);
        }
        
        /* Buttons */
        .btn-auth-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 15px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            width: 100%;
        }
        
        .btn-auth-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-auth-primary:hover::before {
            left: 100%;
        }
        
        .btn-auth-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        }
        
        .btn-auth-primary:active {
            transform: translateY(0);
        }
        
        /* Links */
        .auth-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .auth-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }
        
        .auth-link:hover {
            color: var(--primary-dark);
        }
        
        .auth-link:hover::after {
            width: 100%;
        }
        
        /* Checkbox */
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 53, 0.25);
        }
        
        .form-check-label {
            color: #6c757d;
            font-weight: 500;
        }
        
        /* Error Messages */
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
            font-weight: 500;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }
        
        /* Divider */
        .auth-divider {
            position: relative;
            text-align: center;
            margin: 2rem 0;
        }
        
        .auth-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(108, 117, 125, 0.3), transparent);
        }
        
        .auth-divider span {
            background: rgba(255, 255, 255, 0.95);
            color: #6c757d;
            padding: 0 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        /* Footer Links */
        .auth-footer {
            text-align: center;
            padding: 1.5rem 2rem;
            background: rgba(248, 249, 250, 0.5);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .auth-footer p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .auth-container {
                padding: 1rem;
            }
            
            .auth-header,
            .auth-body,
            .auth-footer {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
            
            .auth-title {
                font-size: 1.75rem;
            }
        }
        
        /* Loading Animation */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }
        
        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid var(--white);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        
        /* Success Message */
        .alert-success {
            background: rgba(25, 135, 84, 0.1);
            border: 1px solid rgba(25, 135, 84, 0.2);
            color: #0f5132;
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        /* Status Messages */
        .auth-status {
            background: rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.2);
            color: var(--primary-dark);
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card" style="width: 100%; max-width: 450px;">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Add loading animation to forms
            $('form').on('submit', function() {
                const submitBtn = $(this).find('button[type="submit"]');
                if (submitBtn.length) {
                    submitBtn.addClass('btn-loading');
                    submitBtn.prop('disabled', true);
                }
            });
            
            // Add focus animations
            $('.form-control').on('focus', function() {
                $(this).closest('.form-floating').addClass('animate__animated animate__pulse');
            });
            
            $('.form-control').on('blur', function() {
                $(this).closest('.form-floating').removeClass('animate__animated animate__pulse');
            });
            
            // Auto-hide alerts
            setTimeout(function() {
                $('.alert, .auth-status').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>
