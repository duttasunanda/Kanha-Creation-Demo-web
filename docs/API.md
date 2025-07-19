# 🔌 API Reference - Nilkamal Furniture Platform

## 🛣️ Route Structure

### Public Routes
Routes accessible without authentication.

#### Homepage
- **GET** `/` - Display homepage with featured products and categories
- **Controller**: `HomeController@index`
- **View**: `home.blade.php`

#### Products
- **GET** `/products` - Product catalog with filters and search
- **GET** `/products/{product:slug}` - Individual product details
- **Controller**: `ProductController@index`, `ProductController@show`
- **Views**: `products/index.blade.php`, `products/show.blade.php`

#### Categories
- **GET** `/categories/{category:slug}` - Products by category
- **Controller**: `CategoryController@show`
- **View**: `categories/show.blade.php`

### Authentication Routes
User login and registration.

- **GET** `/login` - Show login form
- **POST** `/login` - Process login
- **GET** `/register` - Show registration form
- **POST** `/register` - Process registration
- **POST** `/logout` - Logout user
- **Controller**: `Auth\AuthController`

### Authenticated Routes
Routes requiring user login.

#### Shopping Cart
- **GET** `/cart` - View cart contents
- **POST** `/cart/add` - Add product to cart
- **PUT** `/cart/update/{cartItem}` - Update cart item quantity
- **DELETE** `/cart/remove/{cartItem}` - Remove item from cart
- **DELETE** `/cart/clear` - Clear entire cart
- **Controller**: `CartController`

#### Checkout
- **GET** `/checkout` - Checkout form
- **POST** `/checkout/process` - Process order
- **GET** `/checkout/success/{order}` - Order confirmation
- **GET** `/checkout/cancel` - Order cancellation
- **Controller**: `CheckoutController`

#### User Profile
- **GET** `/profile` - User profile page
- **GET** `/profile/edit` - Edit profile form
- **PUT** `/profile` - Update profile
- **Controller**: `ProfileController`

#### Orders
- **GET** `/orders` - Order history
- **GET** `/orders/{order}` - Order details
- **POST** `/orders/{order}/cancel` - Cancel order
- **Controller**: `OrderController`

### Admin Routes
Routes requiring admin privileges.

#### Admin Dashboard
- **GET** `/admin` - Admin dashboard
- **Controller**: `Admin\AdminController@index`

#### Product Management
- **GET** `/admin/products` - List all products
- **GET** `/admin/products/create` - Create product form
- **POST** `/admin/products` - Store new product
- **GET** `/admin/products/{product}` - Show product
- **GET** `/admin/products/{product}/edit` - Edit product form
- **PUT** `/admin/products/{product}` - Update product
- **DELETE** `/admin/products/{product}` - Delete product
- **POST** `/admin/products/{product}/toggle-featured` - Toggle featured status
- **Controller**: `Admin\ProductController`

#### Category Management
- **GET** `/admin/categories` - List all categories
- **GET** `/admin/categories/create` - Create category form
- **POST** `/admin/categories` - Store new category
- **GET** `/admin/categories/{category}/edit` - Edit category form
- **PUT** `/admin/categories/{category}` - Update category
- **DELETE** `/admin/categories/{category}` - Delete category
- **Controller**: `Admin\CategoryController`

#### Order Management
- **GET** `/admin/orders` - List all orders
- **GET** `/admin/orders/{order}` - Show order details
- **PUT** `/admin/orders/{order}` - Update order
- **POST** `/admin/orders/{order}/update-status` - Update order status
- **Controller**: `Admin\OrderController`

#### User Management
- **GET** `/admin/users` - List all users
- **GET** `/admin/users/{user}/edit` - Edit user form
- **PUT** `/admin/users/{user}` - Update user
- **POST** `/admin/users/{user}/toggle-admin` - Toggle admin status
- **Controller**: `Admin\UserController`

### API Routes
AJAX endpoints for dynamic functionality.

- **GET** `/api/search/products` - Search products (AJAX)
- **GET** `/api/cart/count` - Get cart item count

## 📝 Request/Response Examples

### Add to Cart
**Request:**
```http
POST /cart/add
Content-Type: application/x-www-form-urlencoded

product_id=1&quantity=2
```

**Response:**
```http
HTTP/1.1 302 Found
Location: /cart
Set-Cookie: session=...

Flash Message: "Product added to cart successfully!"
```

### Product Search API
**Request:**
```http
GET /api/search/products?q=chair
Accept: application/json
```

**Response:**
```json
{
  "products": [
    {
      "id": 1,
      "name": "Ergonomic Office Chair",
      "slug": "ergonomic-office-chair",
      "price": "15000",
      "image": "/images/products/chair1.jpg",
      "category": {
        "name": "Chairs"
      }
    }
  ]
}
```

### Order Creation
**Request:**
```http
POST /checkout/process
Content-Type: application/x-www-form-urlencoded

first_name=John&last_name=Doe&email=john@example.com&phone=9876543210&address=123+Main+St&city=Mumbai&pin_code=400001&payment_method=cod
```

**Response:**
```http
HTTP/1.1 302 Found
Location: /checkout/success/123

Flash Message: "Order placed successfully!"
```

## 🔒 Authentication & Authorization

### Middleware Protection

#### Auth Middleware
Applied to routes requiring login:
```php
Route::middleware('auth')->group(function () {
    // Protected routes
});
```

#### Admin Middleware
Applied to admin-only routes:
```php
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin routes
});
```

### Permission Checks
```php
// Check if user is authenticated
if (auth()->check()) {
    // User is logged in
}

// Check if user is admin
if (auth()->user()->is_admin) {
    // User has admin privileges
}

// Check resource ownership
if ($order->user_id === auth()->id()) {
    // User owns this resource
}
```

## 📋 Form Validation Rules

### Product Validation
```php
[
    'name' => 'required|string|max:255',
    'category_id' => 'required|exists:categories,id',
    'price' => 'required|numeric|min:0',
    'description' => 'required|string',
    'stock_quantity' => 'required|integer|min:0',
    'is_active' => 'boolean'
]
```

### User Registration
```php
[
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|string|min:8|confirmed',
    'phone' => 'nullable|string|max:20'
]
```

### Checkout Validation
```php
[
    'first_name' => 'required|string|max:255',
    'last_name' => 'required|string|max:255',
    'email' => 'required|email',
    'phone' => 'required|string',
    'address' => 'required|string',
    'city' => 'required|string',
    'pin_code' => 'required|string|size:6',
    'payment_method' => 'required|in:cod,online'
]
```

## 🔄 Response Types

### View Responses
Most routes return Blade template views:
```php
return view('products.index', compact('products', 'categories'));
```

### Redirect Responses
After form submissions:
```php
return redirect()->route('products.index')
    ->with('success', 'Product created successfully!');
```

### JSON Responses
For AJAX endpoints:
```php
return response()->json([
    'success' => true,
    'data' => $products,
    'message' => 'Products loaded successfully'
]);
```

### Error Responses
```php
// 404 Not Found
abort(404, 'Product not found');

// 403 Forbidden
abort(403, 'Unauthorized access');

// Validation errors (automatic)
return back()->withErrors($validator)->withInput();
```

## 📊 Status Codes

### Success Codes
- **200 OK** - Successful GET requests
- **201 Created** - Successful POST requests
- **302 Found** - Successful redirects after POST

### Client Error Codes
- **400 Bad Request** - Invalid request data
- **401 Unauthorized** - Authentication required
- **403 Forbidden** - Access denied
- **404 Not Found** - Resource not found
- **422 Unprocessable Entity** - Validation errors

### Server Error Codes
- **500 Internal Server Error** - Server-side errors

---

**Next:** [Development Guide →](DEVELOPMENT.md) | **Previous:** [← Backend Guide](BACKEND.md)
