<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
    });

    // Cart Routes
    Route::controller(CartController::class)->prefix('cart')->name('cart.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/add', 'add')->name('add');
        Route::put('/update/{cartItem}', 'update')->name('update');
        Route::delete('/remove/{cartItem}', 'remove')->name('remove');
        Route::delete('/clear', 'clear')->name('clear');
    });

    // Checkout Routes
    Route::controller(CheckoutController::class)->prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/process', 'process')->name('process');
        Route::get('/success/{order}', 'success')->name('success');
        Route::get('/cancel', 'cancel')->name('cancel');
    });

    // Order Routes
    Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{order}', 'show')->name('show');
        Route::post('/{order}/cancel', 'cancel')->name('cancel');
    });
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Product Management
    Route::resource('products', AdminProductController::class);
    Route::post('products/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    
    // Category Management
    Route::resource('categories', AdminCategoryController::class);
    
    // Order Management
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    Route::post('orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // User Management
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
});

// API Routes for AJAX requests
Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('/search/products', [ProductController::class, 'search'])->name('api.products.search');
    Route::get('/cart/count', [CartController::class, 'count'])->name('api.cart.count');
});
