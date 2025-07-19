# 🏗️ Architecture Guide - Nilkamal Furniture Platform

## 📐 System Architecture

### MVC Pattern
The application follows Laravel's MVC (Model-View-Controller) architecture:

```
┌─────────────────────────────────────────────────────────────┐
│                    Frontend (Views)                         │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐         │
│  │   Public    │  │    User     │  │   Admin     │         │
│  │   Pages     │  │   Pages     │  │   Panel     │         │
│  └─────────────┘  └─────────────┘  └─────────────┘         │
└─────────────────────────────────────────────────────────────┘
                           │
┌─────────────────────────────────────────────────────────────┐
│                 Controllers Layer                           │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐         │
│  │   Public    │  │    Auth     │  │   Admin     │         │
│  │ Controllers │  │ Controllers │  │ Controllers │         │
│  └─────────────┘  └─────────────┘  └─────────────┘         │
└─────────────────────────────────────────────────────────────┘
                           │
┌─────────────────────────────────────────────────────────────┐
│                   Models Layer                              │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐         │
│  │   Product   │  │    User     │  │    Order    │         │
│  │   Category  │  │   CartItem  │  │   Address   │         │
│  └─────────────┘  └─────────────┘  └─────────────┘         │
└─────────────────────────────────────────────────────────────┘
```

## 🎯 Controller Structure

### Public Controllers
```php
HomeController        // Homepage and landing
ProductController     // Product catalog and details
CategoryController    // Category browsing
AuthController        // Login/Register
```

### User Controllers
```php
CartController        // Shopping cart management
CheckoutController    // Order processing
ProfileController     // User account management
OrderController       // Order history
```

### Admin Controllers
```php
Admin\AdminController       // Dashboard
Admin\ProductController     // Product CRUD
Admin\CategoryController    // Category CRUD
Admin\OrderController      // Order management
Admin\UserController       // User management
```

## 🛣️ Routing Structure

### Route Groups
```php
// Public routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::resource('cart', CartController::class);
    Route::resource('orders', OrderController::class);
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('products', ProductController::class);
});
```

## 📁 Directory Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   ├── CategoryController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   ├── ProfileController.php
│   │   ├── OrderController.php
│   │   ├── Auth/
│   │   │   └── AuthController.php
│   │   └── Admin/
│   │       ├── AdminController.php
│   │       ├── ProductController.php
│   │       ├── CategoryController.php
│   │       ├── OrderController.php
│   │       └── UserController.php
│   └── Middleware/
│       └── AdminMiddleware.php
├── Models/
│   ├── User.php
│   ├── Product.php
│   ├── Category.php
│   ├── CartItem.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── Address.php
│   └── ProductImage.php
└── Mail/
    ├── OrderConfirmation.php
    └── OrderShipped.php
```

## 🔄 Data Flow

### Customer Purchase Flow
```
1. Browse Products → ProductController::index()
2. View Product → ProductController::show()
3. Add to Cart → CartController::add()
4. View Cart → CartController::index()
5. Checkout → CheckoutController::index()
6. Process Payment → CheckoutController::process()
7. Order Confirmation → CheckoutController::success()
```

### Admin Management Flow
```
1. Login → AuthController::login()
2. Dashboard → AdminController::index()
3. Manage Products → Admin\ProductController
4. Process Orders → Admin\OrderController
5. Update Status → Admin\OrderController::updateStatus()
```

## 🔐 Security Architecture

### Authentication
- Session-based authentication
- CSRF protection on forms
- Password hashing (bcrypt)

### Authorization
- Role-based access control
- Admin middleware protection
- User ownership validation

### Data Validation
- Request validation in controllers
- Model-level validation
- XSS protection

## 📊 Database Design

### Core Tables
```sql
users
├── id, name, email, password
├── phone, is_admin, created_at
└── relationships: orders, cart_items

products
├── id, name, slug, description
├── price, stock_quantity, is_active
└── relationships: category, images, cart_items

categories
├── id, name, slug, description
├── parent_id, status, sort_order
└── relationships: products, children

orders
├── id, user_id, order_number
├── total_amount, status, payment_status
└── relationships: user, order_items

cart_items
├── id, user_id, product_id
├── quantity, price, created_at
└── relationships: user, product
```

## 🔧 Service Architecture

### Future Services (Planned)
```php
PaymentService        // Handle payments
EmailService         // Email notifications
InventoryService     // Stock management
ReportService        // Analytics and reports
```

## 🚀 Performance Considerations

### Database Optimization
- Eager loading relationships
- Database indexing
- Query optimization
- Connection pooling

### Caching Strategy
- Route caching
- Config caching
- View caching
- Database query caching

### Frontend Optimization
- Asset compilation (Vite)
- Image optimization
- CSS/JS minification
- Progressive loading

---

**Next:** [Frontend Guide →](FRONTEND.md) | **Previous:** [← Main README](../README.md)
