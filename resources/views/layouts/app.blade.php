<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Burger Shop') }} - @yield('title', 'Home')</title>

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
    
    <!-- Custom Styles -->
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
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            overflow-x: hidden;
        }
        
        /* Modern Navbar */
        .navbar-modern {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(255, 107, 53, 0.3);
            transition: all 0.3s ease;
            padding: 1rem 0;
            position: relative;
            z-index: 1050;
        }
        
        .navbar-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            animation: shimmer 3s infinite;
            pointer-events: none;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .navbar-brand-modern {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--white) !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .navbar-brand-modern:hover {
            transform: scale(1.05);
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        
        .brand-icon {
            font-size: 2rem;
            background: linear-gradient(45deg, var(--accent), var(--white));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        
        .navbar-nav-modern .nav-link {
            color: var(--white) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            padding: 0.75rem 1.25rem !important;
            border-radius: 50px;
            transition: all 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
            position: relative;
            overflow: visible;
        }
        
        .navbar-nav-modern .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .navbar-nav-modern .nav-link:hover::before {
            left: 100%;
        }
        
        .navbar-nav-modern .nav-link:hover,
        .navbar-nav-modern .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .navbar-nav-modern .nav-link i {
            margin-right: 0.5rem;
            transition: transform 0.3s ease;
        }
        
        .navbar-nav-modern .nav-link:hover i {
            transform: scale(1.2);
        }
        
        /* Cart Badge Modern */
        .cart-badge-modern {
            position: absolute;
            top: -15px;
            right: -15px;
            background: linear-gradient(45deg, var(--accent), #E67E22);
            color: var(--white);
            font-size: 0.85rem;
            font-weight: 800;
            padding: 0.45rem 0.75rem;
            border-radius: 50px;
            min-width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(243, 156, 18, 0.7);
            animation: pulse 2s infinite;
            border: 5px solid var(--white);
            line-height: 1;
            z-index: 1060;
            transform: translateZ(0);
            font-family: 'Poppins', sans-serif;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .nav-link:hover .cart-badge-modern {
            transform: scale(1.25) translateZ(0);
            animation: none;
            box-shadow: 0 10px 30px rgba(243, 156, 18, 0.8);
        }
        
        /* Dropdown Modern */
        .dropdown-menu-modern {
            background: var(--white);
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 1rem 0;
            margin-top: 0.5rem;
            animation: slideInDown 0.3s ease;
        }
        
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-item-modern {
            padding: 0.75rem 1.5rem;
            color: var(--dark);
            transition: all 0.3s ease;
            border-radius: 0;
        }
        
        .dropdown-item-modern:hover {
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            color: var(--white);
            transform: translateX(5px);
        }
        
        .dropdown-item-modern i {
            width: 20px;
            margin-right: 0.75rem;
        }
        
        /* Mobile Toggle */
        .navbar-toggler-modern {
            border: none;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .navbar-toggler-modern:focus {
            box-shadow: none;
        }
        
        .navbar-toggler-modern .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 50%, var(--accent) 100%);
            padding: 6rem 0;
            min-height: 60vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,122.7C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') bottom/cover no-repeat;
            animation: wave 15s linear infinite;
        }
        
        @keyframes wave {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(45deg, var(--primary), var(--primary-light));
            border: none;
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
        }
        
        .text-primary {
            color: var(--primary) !important;
        }
        
        /* Product Cards */
        .product-card {
            transition: all 0.4s cubic-bezier(0.4, 0.0, 0.2, 1);
            border-radius: 20px;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
    
        
        .btn-primary:hover,
        .btn-primary:focus {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary));
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
        }
        
        .text-primary {
            color: var(--primary) !important;
        }
        
        /* Modern Footer */
        .footer-modern {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--dark) 100%);
            color: var(--white);
            position: relative;
            overflow: hidden;
        }
        
        .footer-waves {
            position: absolute;
            top: -1px;
            left: 0;
            width: 100%;
            height: 100px;
            overflow: hidden;
            line-height: 0;
        }
        
        .footer-waves svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 100px;
            animation: wave-animation 6s linear infinite;
        }
        
        @keyframes wave-animation {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        .footer-content {
            padding: 120px 0 3rem;
            position: relative;
            z-index: 2;
        }
        
        .footer-brand {
            margin-bottom: 2rem;
        }
        
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .brand-logo i {
            font-size: 2.5rem;
            color: var(--primary);
            animation: rotate 4s linear infinite;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .brand-logo h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .brand-description {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.7;
            margin-bottom: 2rem;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
        }
        
        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            color: var(--white);
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .social-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .social-link:hover::before {
            left: 100%;
        }
        
        .social-link:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 10px 20px rgba(255, 107, 53, 0.4);
        }
        
        .footer-section {
            margin-bottom: 2rem;
        }
        
        .section-title {
            color: var(--white);
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            border-radius: 2px;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            padding: 0.25rem 0;
        }
        
        .footer-links a:hover {
            color: var(--primary);
            transform: translateX(5px);
        }
        
        .footer-links a i {
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }
        
        .footer-links a:hover i {
            transform: translateX(3px);
        }
        
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .contact-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            border-radius: 10px;
            color: var(--white);
            flex-shrink: 0;
        }
        
        .contact-details p {
            margin: 0;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }
        
        .footer-newsletter {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 3rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .footer-newsletter h4 {
            color: var(--white);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .footer-newsletter p {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0;
        }
        
        .newsletter-form .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--white);
            padding: 0.75rem 1rem;
            border-radius: 50px 0 0 50px;
        }
        
        .newsletter-form .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .newsletter-form .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--primary);
            box-shadow: none;
            color: var(--white);
        }
        
        .newsletter-form .btn {
            border-radius: 0 50px 50px 0;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }
        
        .footer-bottom {
            background: rgba(0, 0, 0, 0.3);
            padding: 1.5rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .copyright {
            margin: 0;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .footer-bottom-links {
            display: flex;
            justify-content: flex-end;
            gap: 1.5rem;
        }
        
        .footer-bottom-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .footer-bottom-links a:hover {
            color: var(--primary);
        }
        
        /* Responsive Design */
        @media (max-width: 991.98px) {
            .navbar-nav-modern {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 15px;
                margin-top: 1rem;
                padding: 1rem;
            }
            
            .navbar-nav-modern .nav-link {
                margin: 0.25rem 0;
                text-align: center;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Modern Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-modern">
        <div class="container">
            <a class="navbar-brand-modern" href="{{ route('home') }}">
                <i class="fas fa-hamburger brand-icon"></i>
                <span>Burger Shop</span>
            </a>
            
            <button class="navbar-toggler navbar-toggler-modern" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavModern">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNavModern">
                <ul class="navbar-nav navbar-nav-modern ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fas fa-utensils"></i>Menu
                        </a>
                    </li>
                    <li class="nav-item position-relative" style="z-index: 1061;">
                        <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}" style="position: relative; overflow: visible;">
                            <i class="fas fa-shopping-cart"></i>Cart
                            @php
                                $cartCount = 0;
                                $cartItems = session('cart') ? session('cart') : [];
                                foreach($cartItems as $item) {
                                    $cartCount += $item['quantity'] ?? 1;
                                }
                            @endphp
                            @if($cartCount > 0)
                                <span class="cart-badge-modern" id="cart-count">{{ $cartCount }}</span>
                            @else
                                <span class="cart-badge-modern" id="cart-count" style="display: none;">0</span>
                            @endif
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                                <i class="fas fa-clipboard-list"></i>My Orders
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-modern dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item dropdown-item-modern" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-edit"></i>My Profile
                                    </a>
                                </li>
                                @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item dropdown-item-modern" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i>Admin Dashboard
                                    </a>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item dropdown-item-modern w-100 text-start">
                                            <i class="fas fa-sign-out-alt"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i>Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Modern Footer -->
    <footer class="footer-modern mt-5">
        <div class="footer-waves">
            <svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                <path fill="var(--primary)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,122.7C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
        
        <div class="footer-content">
            <div class="container">
                <div class="row g-4">
                    <!-- Brand Section -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-brand">
                            <div class="brand-logo">
                                <i class="fas fa-hamburger"></i>
                                <h3>Burger Shop</h3>
                            </div>
                            <p class="brand-description">
                                Crafting delicious burgers and crispy chicken with fresh, premium ingredients. 
                                Your satisfaction is our passion.
                            </p>
                            <div class="social-links">
                                <a href="#" class="social-link" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="social-link" aria-label="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="social-link" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="social-link" aria-label="Youtube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-6">
                        <div class="footer-section">
                            <h5 class="section-title">Quick Links</h5>
                            <ul class="footer-links">
                                <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right"></i>Home</a></li>
                                <li><a href="{{ route('products.index') }}"><i class="fas fa-chevron-right"></i>Menu</a></li>
                                <li><a href="#"><i class="fas fa-chevron-right"></i>About Us</a></li>
                                <li><a href="#"><i class="fas fa-chevron-right"></i>Contact</a></li>
                                <li><a href="#"><i class="fas fa-chevron-right"></i>Careers</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Categories -->
                    <div class="col-lg-2 col-md-6">
                        <div class="footer-section">
                            <h5 class="section-title">Categories</h5>
                            <ul class="footer-links">
                                <li><a href="{{ route('products.index', ['category' => 'burger']) }}"><i class="fas fa-chevron-right"></i>Burgers</a></li>
                                <li><a href="{{ route('products.index', ['category' => 'chicken']) }}"><i class="fas fa-chevron-right"></i>Chicken</a></li>
                                <li><a href="{{ route('products.index', ['category' => 'sides']) }}"><i class="fas fa-chevron-right"></i>Sides</a></li>
                                <li><a href="{{ route('products.index', ['category' => 'drinks']) }}"><i class="fas fa-chevron-right"></i>Beverages</a></li>
                                <li><a href="{{ route('products.index', ['category' => 'desserts']) }}"><i class="fas fa-chevron-right"></i>Desserts</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-section">
                            <h5 class="section-title">Get In Touch</h5>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="contact-details">
                                        <p>123 Burger Street, Food City<br>Ho Chi Minh City, Vietnam</p>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="contact-details">
                                        <p>+84 123 456 789<br>+84 987 654 321</p>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="contact-details">
                                        <p>info@burgershop.com<br>support@burgershop.com</p>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="contact-details">
                                        <p>Mon - Sun: 9:00 AM - 11:00 PM<br>Delivery Available 24/7</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div class="footer-newsletter">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4>Stay Updated</h4>
                            <p>Subscribe to get special offers, free giveaways, and delicious updates!</p>
                        </div>
                        <div class="col-md-6">
                            <form class="newsletter-form">
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Enter your email address">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-paper-plane"></i>Subscribe
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="copyright">&copy; {{ date('Y') }} Burger Shop. All rights reserved.</p>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-bottom-links">
                            <a href="#">Privacy Policy</a>
                            <a href="#">Terms of Service</a>
                            <a href="#">Cookie Policy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>       

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- jQuery UI (for animations) -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    
    <!-- Toast container for notifications -->
    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080;"></div>
    
    <!-- Cart Update Script -->
    <script>
        // Function to update cart count via AJAX
        function updateCartCount() {
            $.ajax({
                url: '{{ route("cart.count") }}',
                type: 'GET',
                success: function(response) {
                    if (response.count <= 0) {
                        $('#cart-count').text('0').hide();
                    } else {
                        $('#cart-count').text(response.count).show();
                        // Add modern bounce animation when count changes
                        $('#cart-count').addClass('animate__animated animate__bounceIn');
                        setTimeout(function() {
                            $('#cart-count').removeClass('animate__animated animate__bounceIn');
                        }, 1000);
                    }
                }
            });
        }

        // Run initially when page loads
        $(document).ready(function() {
            let cartCount = parseInt($('#cart-count').text());
            if (cartCount <= 0) {
                $('#cart-count').hide();
            }
            
            // Update cart count every 30 seconds
            setInterval(updateCartCount, 30000);
            
            // Add smooth scroll behavior for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });
            
            // Add loading animation to forms
            $('form').on('submit', function() {
                const submitBtn = $(this).find('button[type="submit"]');
                if (submitBtn.length && !submitBtn.hasClass('no-loading')) {
                    submitBtn.prop('disabled', true);
                    const originalText = submitBtn.html();
                    submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Processing...');
                    
                    // Re-enable after 5 seconds in case of error
                    setTimeout(function() {
                        submitBtn.prop('disabled', false);
                        submitBtn.html(originalText);
                    }, 5000);
                }
            });
            
            // Add hover effect to cards
            $('.product-card, .card').hover(
                function() {
                    $(this).addClass('animate__animated animate__pulse');
                },
                function() {
                    $(this).removeClass('animate__animated animate__pulse');
                }
            );
        });
    </script>
    
    <!-- Cart JS -->
    <script src="{{ asset('js/cart.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
