# 🍔 Burger Shop - Laravel E-Commerce Application

## Họ Tên Sinh Viên : Đinh Thị Như Quỳnh 
## Mã SV : 23010844

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-13+-blue?style=flat-square&logo=postgresql)](https://postgresql.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-cyan?style=flat-square&logo=tailwind-css)](https://tailwindcss.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-purple?style=flat-square&logo=bootstrap)](https://getbootstrap.com)

Một ứng dụng web thương mại điện tử hoàn chỉnh cho cửa hàng burger và gà rán được xây dựng bằng Laravel với các tính năng hiện đại và giao diện responsive.

---

## 📋 Mục Lục

- [✨ Tính Năng Chính](#-tính-năng-chính)
- [🛠️ Công Nghệ Sử Dụng](#️-công-nghệ-sử-dụng)
- [📦 Yêu Cầu Hệ Thống](#-yêu-cầu-hệ-thống)
- [🚀 Hướng Dẫn Cài Đặt](#-hướng-dẫn-cài-đặt)
- [⚙️ Cấu Hình Environment](#️-cấu-hình-environment)
- [🗄️ Cấu Hình Database](#️-cấu-hình-database)
- [📧 Cấu Hình Email](#-cấu-hình-email)
- [💳 Cấu Hình Thanh Toán VNPAY](#-cấu-hình-thanh-toán-vnpay)More actions
- [🎯 Chạy Ứng Dụng](#-chạy-ứng-dụng)
- [👤 Tài Khoản Mặc Định](#-tài-khoản-mặc-định)
- [📁 Cấu Trúc Project](#-cấu-trúc-project)
- [🔐 Hệ Thống Authentication](#-hệ-thống-authentication)
- [🎨 Frontend & UI](#-frontend--ui)
- [🛒 Tính Năng E-Commerce](#-tính-năng-e-commerce)
- [🌐 API Endpoints](#-api-endpoints)
- [🐛 Troubleshooting](#-troubleshooting)
- [📝 Contributing](#-contributing)
- [📄 License](#-license)

---

## ✨ Tính Năng Chính

### 🔐 **Authentication & Security**
- ✅ **Đăng ký/Đăng nhập** với xác thực OTP qua email
- ✅ **Phân quyền người dùng** (Admin/User) với Role-based Access Control
- ✅ **Xác minh email** bắt buộc trước khi truy cập tài khoản
- ✅ **Quản lý profile** với khả năng đổi mật khẩu
- ✅ **Session management** và CSRF protection

### 🛍️ **E-Commerce Core**
- ✅ **Catalog sản phẩm** với phân loại và tìm kiếm thông minh
- ✅ **Giỏ hàng** với AJAX updates và persistent storage
- ✅ **Hệ thống đặt hàng** hoàn chỉnh với tracking
- ✅ **Tích hợp thanh toán VNPAY** cho thị trường Việt Nam
- ✅ **Quản lý inventory** với trạng thái sản phẩm

### 🎨 **User Experience**
- ✅ **Responsive design** tương thích mobile/tablet/desktop
- ✅ **Tìm kiếm Vietnamese-friendly** (hỗ trợ không dấu)
- ✅ **Product cards đồng nhất** với animations mượt mà
- ✅ **Interactive UI** với loading states và feedback
- ✅ **Modern design** sử dụng Bootstrap 5 + Tailwind CSS

### 👑 **Admin Panel**
- ✅ **Dashboard quản trị** với thống kê tổng quan
- ✅ **Quản lý sản phẩm** (CRUD operations)
- ✅ **Quản lý đơn hàng** với cập nhật trạng thái
- ✅ **Quản lý người dùng** và verification control
- ✅ **Admin middleware** với bảo mật cao

### 🔍 **Advanced Features**
- ✅ **Vietnamese search** với SearchableTrait
- ✅ **Email notifications** cho OTP và orders
- ✅ **Database migrations** với proper relationships
- ✅ **Factory và Seeders** cho test data
- ✅ **Error handling** và logging system

---

## 🛠️ Công Nghệ Sử Dụng

### **Backend Framework**
- **Laravel 12.x** - Modern PHP framework
- **PHP 8.2+** - Latest PHP features

### **Frontend Technologies**
- **Blade Templates** - Laravel's templating engine
- **Tailwind CSS 3.x** - Utility-first CSS framework
- **Bootstrap 5.x** - Component library
- **Alpine.js** - Lightweight JavaScript framework
- **Vite** - Modern build tool

### **Database & Storage**
- **Supabase (PostgreSQL)** - Cloud-hosted PostgreSQL
- **Redis** (optional) - Caching and sessions
- **Local/S3 Storage** - File uploads

### **Payment & Services**
- **VNPAY** - Vietnamese payment gateway
- **SMTP/Mailtrap** - Email delivery
- **Laravel Fortify** - Authentication scaffolding

### **Development Tools**
- **Composer** - PHP dependency management
- **NPM** - Node.js package manager
- **Laravel Pint** - Code style fixer
- **PHPUnit** - Testing framework

---

## 📦 Yêu Cầu Hệ Thống

### **Môi Trường Development**
```bash
PHP >= 8.2
Composer >= 2.0
Node.js >= 18.x
NPM >= 9.x
Git
```

### **Web Server (Production)**
```bash
Apache/Nginx
SSL Certificate (khuyến nghị)
```

### **Database**
```bash
PostgreSQL >= 13.x (Supabase)
# Hoặc local PostgreSQL instance
```

### **Optional Services**
```bash
Redis Server (cho caching)
SMTP Server (cho email)
```

---

## 🚀 Hướng Dẫn Cài Đặt

### **Bước 1: Clone Repository**
```bash
git clone https://github.com/username/burger-shop.git
cd burger-shop
```

### **Bước 2: Cài Đặt Dependencies**
```bash
# Cài đặt PHP dependencies
composer install

# Cài đặt Node.js dependencies
npm install
```

### **Bước 3: Environment Setup**
```bash
# Copy file env example
copy .env.example .env

# Generate application key
php artisan key:generate
```

### **Bước 4: Database Setup**
```bash
# Run migrations
php artisan migrate

# Seed database với test data
php artisan db:seed
```

### **Bước 5: Build Assets**
```bash
# Development build
npm run dev

# Production build
npm run build
```

### **Bước 6: Khởi Động Server**
```bash
php artisan serve
```

🎉 **Truy cập ứng dụng tại:** `http://localhost:8000`

---

## ⚙️ Cấu Hình Environment

### **Cấu Hình Cơ Bản (.env)**
```env
APP_NAME="Burger Shop"
APP_ENV=local
APP_KEY=base64:generated-key-here
APP_DEBUG=true
APP_URL=http://localhost:8000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

LOG_CHANNEL=stack
LOG_LEVEL=debug
```

### **Session & Cache**
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

CACHE_STORE=database
QUEUE_CONNECTION=database
```

### **Security Settings**
```env
BCRYPT_ROUNDS=12
SESSION_SECURE_COOKIE=false
SESSION_HTTP_ONLY=true
```

---

## 🗄️ Cấu Hình Database

### **Supabase (Khuyến nghị)**
```env
DB_CONNECTION=supabase

# Thông tin từ Supabase Dashboard
SUPABASE_DB_HOST=your-project-ref.supabase.co
SUPABASE_DB_PORT=5432
SUPABASE_DB_DATABASE=postgres
SUPABASE_DB_USERNAME=postgres
SUPABASE_DB_PASSWORD=your-password
SUPABASE_DB_URL=postgresql://postgres:password@host:5432/postgres
```

### **PostgreSQL Local**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=burger_shop
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### **MySQL (Alternative)**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=burger_shop
DB_USERNAME=root
DB_PASSWORD=
```

---

## 📧 Cấu Hình Email

### **SMTP Configuration**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@burgershop.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### **Mailtrap (Development)**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

### **Gmail Setup**
1. Bật **2-Factor Authentication**
2. Tạo **App Password** trong Google Account
3. Sử dụng App Password làm `MAIL_PASSWORD`

---

## 💳 Cấu Hình Thanh Toán VNPAY

### **VNPAY Sandbox**
```env
VNPAY_TMN_CODE=your-tmn-code
VNPAY_HASH_SECRET=your-hash-secret
VNPAY_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNPAY_RETURN_URL=${APP_URL}/payment/callback
```

### **VNPAY Production**
```env
VNPAY_TMN_CODE=your-production-tmn-code
VNPAY_HASH_SECRET=your-production-hash-secret
VNPAY_URL=https://vnpayment.vn/paymentv2/vpcpay.html
VNPAY_RETURN_URL=${APP_URL}/payment/callback
```

### **Đăng Ký VNPAY**
1. Truy cập [VNPAY Business](https://vnpay.vn/)
2. Đăng ký tài khoản merchant
3. Lấy TMN Code và Hash Secret
4. Cấu hình Return URL trong dashboard


### **Checkout với VNPAY**
1. Trọn sản phẩm và add to cart
2. Chọn thanh toán -> VNPAY
3. Chọn thẻ nội địa (NCB), nhập số thẻ: 9704198526191432198, NGUYEN VAN A, 07/15
4. Nhập OTP 123456.

---

## **1. UseCase**
![image](https://github.com/user-attachments/assets/97cdc58e-e971-4f5f-85cb-20b24ea26793)

<p align="center"><em>Figure 1.1: usecase</em></p>

## **2.Class diagram**
![image](https://github.com/user-attachments/assets/b66e65d5-9437-49ca-bf5e-9318166b45c8)

<p align="center"><em>Figure 2.1: class diagram</em></p>

## **3. Activity diagram**
![image](https://github.com/user-attachments/assets/09a9119f-8bd4-4622-800c-711ec8204816)

<p align="center"><em>Figure 3.1: đăng ký</em></p>

![image](https://github.com/user-attachments/assets/3867439e-a7fc-4e97-9f06-fd5bf9ab9b36)

<p align="center"><em>Figure 3.2: đăng nhập</em></p>

![image](https://github.com/user-attachments/assets/f52b4bb0-e463-4305-83fb-eb9c428b12de)

<p align="center"><em>Figure 3.3: xem danh sách sản phẩm</em></p>

![image](https://github.com/user-attachments/assets/66e50fd0-67c7-4939-a9c2-23652fffb0ef)

<p align="center"><em>Figure 3.4: đặt hàng sản phẩm</em></p>

![image](https://github.com/user-attachments/assets/a692a2d1-2d92-4627-9a1f-9d67f11b17cc)

<p align="center"><em>Figure 3.5: xem lịch sử</em></p>

![image](https://github.com/user-attachments/assets/040e29dc-06ae-4b1f-b189-fa91af71322c)

<p align="center"><em>Figure 3.6: thanh toán đơn hàng</em></p>

![image](https://github.com/user-attachments/assets/5dc5f545-43d8-4693-a430-c21486a1d5b8)

<p align="center"><em>Figure 3.7: quản lý sản phẩm</em></p>

![image](https://github.com/user-attachments/assets/b65e4e2a-15e1-438a-b650-9c731864545d)

<p align="center"><em>Figure 3.8: quản lý đơn hànghàng</em></p>

---

## 🏢 Quy Trình Nghiệp Vụ 

![image](https://github.com/user-attachments/assets/4d251cd1-75cd-4fcd-b556-3c43979df89c)

<p align="center"><em>Giao diện đăng ký</em></p>

![image](https://github.com/user-attachments/assets/3fa61080-f605-4e95-8361-171b05c64b8c)

<p align="center"><em>Giao diện đăng nhập</em></p>

![image](https://github.com/user-attachments/assets/237d86dd-3db4-4bc3-aacb-282b5305316a)

<p align="center"><em>Giao diện Menu</em></p>

![image](https://github.com/user-attachments/assets/d6cbf5a5-71e6-4c05-9765-4020dd8dfe10)

<p align="center"><em>Giao diện Cart</em></p>

![image](https://github.com/user-attachments/assets/1b76db14-d928-4131-9ab2-33d7a1e608cf)

<p align="center"><em>Giao diện My Orders</em></p>

![image](https://github.com/user-attachments/assets/25e59c43-4abb-4ce5-8104-59963ade48a8)

<p align="center"><em>Giao  Admin Panel / Quản trị</em></p>

![image](https://github.com/user-attachments/assets/17fee421-a18f-411b-b79d-7fe7951f5db8)

<p align="center"><em>Quản lý sản phẩm trong cửa hàng burger</em></p>

![image](https://github.com/user-attachments/assets/357753f1-2e18-4367-a07a-8571421f614c)

<p align="center"><em>Quản lý tài khoản người dùng và phân quyền</em></p>

![image](https://github.com/user-attachments/assets/4ee14e90-4557-406e-baf0-98c66e687b0b)

<p align="center"><em>Quản lý tất cả đơn hàng của khách hàng</em></p>

![image](https://github.com/user-attachments/assets/281397ec-46a2-4046-886b-a2eeef155061)

<p align="center"><em>Giao diện đặt hàng thành </em></p>

---


## Một số số Code Minh Họa 
** order.php **
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total_price',
        'payment_method',
        'status',
        'address',
        'phone',
        'notes',
        'transaction_id',
    ];
    
    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the order items for the order.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
```
** ProductController.php **
```php
// app/Http/Controllers/ProductController.php

public function index(Request $request)
{
    $query = Product::query();

    // Debug log (kiểm tra số lượng sản phẩm)
    Log::info("Total products: " . Product::count());

    // Lọc theo trạng thái còn hàng
    $query->where('available', true);

    // Lọc theo danh mục nếu có
    if ($request->has('category') && !empty($request->category)) {
        $query->where('category', $request->category);
    }

    // Tìm kiếm theo tên hoặc mô tả nếu có
    if ($request->has('search') && !empty($request->search)) {
        $this->applySearchToQuery($query, $request->search, ['name', 'description']);
    }

    // Sắp xếp theo giá hoặc tên
    if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
        $query->orderBy('price', $request->sort);
    } else {
        $query->orderBy('name');
    }

    // Phân trang 24 sản phẩm mỗi trang
    $products = $query->paginate(24)->withQueryString();

    return view('products.index', compact('products'));
}
```


## 🎯 Chạy Ứng Dụng

### **Development Mode**
```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Watch assets (optional)
npm run dev

# Terminal 3: Queue worker (nếu sử dụng)
php artisan queue:work
```

### **Production Deployment**
```bash
# Build production assets
npm run build

# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Seed production data
php artisan db:seed --class=ProductSeeder
```

### **Kiểm Tra Hoạt Động**
- ✅ Trang chủ: `http://localhost:8000`
- ✅ Products: `http://localhost:8000/products`
- ✅ Admin: `http://localhost:8000/admin`
- ✅ API Health: `http://localhost:8000/debug/products`

---

## 👤 Tài Khoản Mặc Định

### **Admin Account**
```
Email: admin@burgershop.com
Password: password
Role: admin
```

### **Regular User**
```
Email: user@example.com
Password: password
Role: user
```

### **Test Features**
1. **Login với admin** → Truy cập admin panel
2. **Login với user** → Test shopping flow
3. **Đăng ký user mới** → Test OTP verification
4. **Test search** → Thử "banh mi", "ga ran"
5. **Test cart** → Add products và checkout

---

## 📁 Cấu Trúc Project

```
burger-shop/
├── 📂 app/
│   ├── 📂 Http/
│   │   ├── 📂 Controllers/          # API & Web Controllers
│   │   │   ├── 📂 Admin/           # Admin panel controllers
│   │   │   ├── CartController.php   # Shopping cart logic
│   │   │   ├── ProductController.php # Product catalog
│   │   │   ├── OrderController.php  # Order management
│   │   │   └── PaymentController.php # Payment processing
│   │   ├── 📂 Middleware/          # Custom middleware
│   │   │   ├── AdminMiddleware.php  # Admin access control
│   │   │   └── EnsureOtpVerified.php # OTP verification
│   │   └── 📂 Requests/            # Form validation
│   ├── 📂 Models/                  # Eloquent models
│   │   ├── User.php               # User model với roles
│   │   ├── Product.php            # Product catalog
│   │   ├── Order.php              # Order management
│   │   └── OtpCode.php            # OTP verification
│   └── 📂 Traits/                 # Reusable traits
│       └── SearchableTrait.php    # Vietnamese search
├── 📂 database/
│   ├── 📂 migrations/             # Database schema
│   ├── 📂 seeders/               # Test data
│   └── 📂 factories/             # Model factories
├── 📂 resources/
│   ├── 📂 views/                 # Blade templates
│   │   ├── 📂 admin/            # Admin panel views
│   │   ├── 📂 auth/             # Authentication pages
│   │   ├── 📂 products/         # Product catalog
│   │   ├── 📂 cart/            # Shopping cart
│   │   └── 📂 layouts/         # Layout templates
│   ├── 📂 css/                  # Styling assets
│   └── 📂 js/                   # JavaScript assets
├── 📂 routes/
│   ├── web.php                  # Web routes
│   └── auth.php                # Authentication routes
└── 📂 config/                   # Configuration files
    ├── vnpay.php               # VNPAY settings
    ├── database.php            # Database connections
    └── mail.php                # Email configuration
```

---

## 🔐 Hệ Thống Authentication

### **Luồng Đăng Ký**
1. **User đăng ký** → Gửi OTP qua email
2. **Nhập OTP** → Xác minh tài khoản
3. **Account activated** → Có thể sử dụng đầy đủ

### **Middleware Stack**
```php
// User routes
Route::middleware(['auth', 'otp_verified'])

// Admin routes  
Route::middleware(['auth', 'otp_verified', 'admin'])
```

### **Role System**
- **admin**: Full access to admin panel
- **user**: Standard customer access

### **OTP Verification**
- **Thời gian hết hạn**: 10 phút
- **Resend**: Có thể gửi lại sau 60 giây
- **Email template**: Có thể customize

---

## 🎨 Frontend & UI

### **Design System**
- **Color scheme**: Orange primary (#ff6b00)
- **Typography**: System fonts với fallbacks
- **Components**: Bootstrap 5 + custom CSS
- **Icons**: Font Awesome 6

### **Responsive Breakpoints**
```css
/* Mobile First Approach */
sm: 576px   /* Small devices */
md: 768px   /* Medium devices */
lg: 992px   /* Large devices */
xl: 1200px  /* Extra large devices */
```

### **Key UI Features**
- ✅ **Uniform product cards** với fixed dimensions
- ✅ **Hover animations** và micro-interactions
- ✅ **Loading states** cho user feedback
- ✅ **Vietnamese search hints** trong placeholder
- ✅ **Mobile-optimized** touch interactions

### **Build Process**
```bash
# Development với hot reload
npm run dev

# Production optimization
npm run build

# Asset watching
npm run dev -- --watch
```

---

## 🛒 Tính Năng E-Commerce

### **Product Management**
- **Categories**: burger, chicken, sides, drinks, desserts
- **Search**: Vietnamese-friendly với accent removal
- **Filtering**: Category, price sorting
- **Images**: Support multiple formats
- **Availability**: Stock status tracking

### **Shopping Cart**
- **Session-based** persistence
- **AJAX updates** không reload page
- **Quantity management** với validation
- **Total calculation** với tax/shipping
- **Guest checkout** available

### **Order Processing**
1. **Add to cart** → Session storage
2. **Checkout** → Order creation
3. **Payment** → VNPAY redirect
4. **Confirmation** → Email notification
5. **Tracking** → Status updates

### **Payment Flow**
```
Cart → Checkout → VNPAY → Callback → Confirmation
```

---

## 🌐 API Endpoints

### **Public Routes**
```http
GET  /                          # Homepage
GET  /products                  # Product catalog
GET  /products/{id}             # Product detail
POST /cart/add                  # Add to cart
```

### **Authentication Required**
```http
GET  /profile                   # User profile
POST /orders                    # Create order
GET  /orders/{id}              # Order detail
GET  /checkout                 # Checkout page
```

### **Admin Only**
```http
GET  /admin/dashboard          # Admin dashboard
GET  /admin/products           # Product management
GET  /admin/orders            # Order management
GET  /admin/users             # User management
```

### **API Testing**
```bash
# Health check
curl http://localhost:8000/debug/products

# Product search
curl "http://localhost:8000/products?search=banh"
```

---

## 🐛 Troubleshooting

### **Common Issues**

#### **Database Connection Error**
```bash
# Check database credentials
php artisan config:clear
php artisan migrate:status
```

#### **OTP Email Not Sending**
```bash
# Test email configuration
php artisan tinker
Mail::raw('Test', function($msg) { $msg->to('test@example.com'); });
```

#### **Asset Build Errors**
```bash
# Clear npm cache
npm cache clean --force
rm -rf node_modules
npm install
```

#### **Permission Errors**
```bash
# Fix storage permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### **Debugging Tools**
```bash
# View logs
php artisan log:clear
tail -f storage/logs/laravel.log

# Debug mode
APP_DEBUG=true

# Query debugging
DB_CONNECTION=sqlite
```

### **Performance Issues**
```bash
# Cache optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear all caches
php artisan optimize:clear
```

---

## 📝 Contributing

### **Development Workflow**
1. **Fork** repository
2. **Create feature branch**: `git checkout -b feature/amazing-feature`
3. **Commit changes**: `git commit -m 'Add amazing feature'`
4. **Push to branch**: `git push origin feature/amazing-feature`
5. **Create Pull Request**

### **Code Standards**
```bash
# PSR-12 compliant
./vendor/bin/pint

# Run tests
php artisan test

# Type checking
./vendor/bin/phpstan analyse
```

### **Database Changes**
```bash
# Create migration
php artisan make:migration create_new_table

# Create seeder
php artisan make:seeder NewTableSeeder
```

---

## 🔧 Advanced Configuration

### **Performance Optimization**
```env
# Production optimizations
APP_ENV=production
APP_DEBUG=false

# Database optimization
DB_CACHE_PREFIX=burger_shop_
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### **Security Hardening**
```env
# HTTPS enforcement
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

# CSRF protection
SANCTUM_STATEFUL_DOMAINS=yourdomain.com
```

### **Monitoring & Logging**
```env
# Log configuration
LOG_CHANNEL=daily
LOG_LEVEL=error
LOG_DAILY_DAYS=30

# Error tracking
SENTRY_LARAVEL_DSN=your-sentry-dsn
```

## 🙏 Acknowledgments

- **Laravel Team** - Amazing framework
- **Tailwind Labs** - Beautiful utility CSS
- **Bootstrap Team** - Reliable components
- **VNPAY** - Payment gateway support
- **Supabase** - Database hosting

---

## 📈 Roadmap

### **Upcoming Features**
- [ ] **Multi-language support** (EN/VI)
- [ ] **Real-time notifications** với WebSockets
- [ ] **Inventory management** system
- [ ] **Loyalty program** và discounts
- [ ] **Mobile app** với React Native
- [ ] **Analytics dashboard** cho admin
- [ ] **Social login** (Google, Facebook)
- [ ] **Reviews & ratings** system

### **Technical Improvements**
- [ ] **API rate limiting**
- [ ] **Docker containerization**
- [ ] **CI/CD pipeline**
- [ ] **Automated testing** coverage
- [ ] **Performance monitoring**
- [ ] **SEO optimization**

