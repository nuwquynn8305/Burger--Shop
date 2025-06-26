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
- [💳 Cấu Hình Thanh Toán VNPAY](#-cấu-hMột số Code Minh Họa 
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

