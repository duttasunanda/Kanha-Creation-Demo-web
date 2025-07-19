# 🛠️ Development Guide - Nilkamal Furniture Platform

## 🚀 Quick Start

### 1. Server Setup
Start the development server:
```bash
php -S localhost:8000 -t public
```

### 2. Access the Website
- **Homepage**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin (coming soon)

### 3. Test Routes
Visit these URLs to test functionality:
- `/products` - Product catalog
- `/cart` - Shopping cart (requires login)
- `/checkout` - Checkout process (requires login)
- `/profile` - User profile (requires login)

## 🗂️ Project Structure Explained

### Controllers (`app/Http/Controllers/`)
Controllers handle HTTP requests and return responses:

```
Controllers/
├── HomeController.php          # Homepage logic
├── ProductController.php       # Product catalog
├── CategoryController.php      # Category pages
├── CartController.php          # Shopping cart
├── CheckoutController.php      # Order processing
├── ProfileController.php       # User profiles
├── OrderController.php         # Order management
├── Auth/
│   └── AuthController.php      # Login/Register
└── Admin/
    ├── AdminController.php     # Admin dashboard
    ├── ProductController.php   # Product CRUD
    ├── CategoryController.php  # Category CRUD
    ├── OrderController.php     # Order management
    └── UserController.php      # User management
```

### Views (`resources/views/`)
Blade templates for the frontend:

```
views/
├── home.blade.php              # Homepage
├── layouts/
│   ├── app.blade.php          # Main layout
│   └── admin.blade.php        # Admin layout
├── products/
│   ├── index.blade.php        # Product listing
│   └── show.blade.php         # Product details
├── categories/
│   └── show.blade.php         # Category page
├── cart/
│   └── index.blade.php        # Shopping cart
├── checkout/
│   ├── index.blade.php        # Checkout form
│   └── success.blade.php      # Order success
├── profile/
│   ├── index.blade.php        # Profile page
│   └── edit.blade.php         # Edit profile
├── orders/
│   ├── index.blade.php        # Order history
│   └── show.blade.php         # Order details
├── auth/
│   ├── login.blade.php        # Login form
│   └── register.blade.php     # Registration
└── admin/
    ├── dashboard.blade.php    # Admin dashboard
    └── products/              # Admin product views
```

### Routes (`routes/web.php`)
URL routing configuration:

```php
// Public routes (no authentication required)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Authenticated routes (login required)
Route::middleware('auth')->group(function () {
    Route::resource('cart', CartController::class);
    Route::resource('orders', OrderController::class);
});

// Admin routes (admin privileges required)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('products', ProductController::class);
});
```

## 🔧 Adding New Features

### 1. Create a New Page

#### Step 1: Add Route
Edit `routes/web.php`:
```php
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
```

#### Step 2: Create Controller
Create `app/Http/Controllers/ContactController.php`:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }
}
```

#### Step 3: Create View
Create `resources/views/contact/index.blade.php`:
```html
@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Contact Us</h1>
    
    <div class="bg-white shadow rounded-lg p-6">
        <p>Get in touch with us!</p>
        
        <form class="mt-6 space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" class="w-full border rounded px-3 py-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Message</label>
                <textarea rows="4" class="w-full border rounded px-3 py-2"></textarea>
            </div>
            
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
                Send Message
            </button>
        </form>
    </div>
</div>
@endsection
```

### 2. Add to Navigation
Edit `resources/views/layouts/app.blade.php` to add the link:
```html
<nav>
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('products.index') }}">Products</a>
    <a href="{{ route('contact') }}">Contact</a>
</nav>
```

## 🎨 Customizing the Design

### 1. Update Colors
Edit the Tailwind classes in your views:
```html
<!-- Change primary color from blue to green -->
<button class="bg-green-600 text-white hover:bg-green-700">
    Click Me
</button>
```

### 2. Modify Layout
Edit `resources/views/layouts/app.blade.php`:
```html
<!-- Add custom header -->
<header class="bg-gray-900 text-white py-4">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl font-bold">Your Furniture Store</h1>
    </div>
</header>
```

### 3. Add Custom CSS
Create `resources/css/custom.css`:
```css
.custom-button {
    @apply bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700;
}

.product-card {
    @apply bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition;
}
```

## 📊 Working with Data

### 1. Mock Data (Current)
Controllers currently use mock data:
```php
public function index()
{
    $products = [
        (object) ['id' => 1, 'name' => 'Chair', 'price' => 5000],
        (object) ['id' => 2, 'name' => 'Table', 'price' => 8000],
    ];
    
    return view('products.index', compact('products'));
}
```

### 2. Database Integration (Future)
When database is set up:
```php
public function index()
{
    $products = Product::with('category')->paginate(12);
    return view('products.index', compact('products'));
}
```

## 🔐 Authentication System

### Current State
- Routes are set up for login/register
- Controllers exist but use mock authentication
- Middleware protection is in place

### Testing Authentication
Currently, you can visit protected routes but they may not enforce authentication properly until the database is connected.

## 🚀 Deployment Preparation

### 1. Environment Configuration
Create `.env` file:
```env
APP_NAME="Nilkamal Furniture"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=furniture_store
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 2. Asset Compilation
```bash
npm run build
```

### 3. Server Configuration
Point web server document root to `/public` folder.

## 🧪 Testing the Application

### Manual Testing Checklist

#### Homepage
- [ ] Loads without errors
- [ ] Categories display correctly
- [ ] Featured products show
- [ ] Navigation links work

#### Product Pages
- [ ] Product listing loads
- [ ] Individual product pages work
- [ ] Add to cart buttons function

#### User Flow
- [ ] Registration form appears
- [ ] Login form appears
- [ ] Cart functionality works
- [ ] Checkout process flows

#### Admin Panel
- [ ] Dashboard loads
- [ ] Product management works
- [ ] User management functions

### Error Checking
Watch for PHP errors in the browser or check server logs:
```bash
tail -f /path/to/php/error.log
```

## 🔧 Troubleshooting

### Common Issues

#### "Route not found" Error
- Check `routes/web.php` for the route definition
- Verify controller method exists
- Check route name matches links

#### "View not found" Error
- Verify view file exists in `resources/views/`
- Check file extension is `.blade.php`
- Verify path matches controller return statement

#### "Controller not found" Error
- Check controller file exists in `app/Http/Controllers/`
- Verify namespace is correct
- Check class name matches filename

### Development Tips

1. **Use descriptive variable names**
2. **Keep controllers focused and small**
3. **Use consistent naming conventions**
4. **Test each feature thoroughly**
5. **Document complex logic**

---

**Next:** [Deployment Guide →](DEPLOYMENT.md) | **Previous:** [← API Reference](API.md)
