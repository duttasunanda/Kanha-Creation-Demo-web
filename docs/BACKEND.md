# ⚙️ Backend Guide - Nilkamal Furniture Platform

## 🏗️ Controller Architecture

### Base Controller Structure
All controllers extend the base `Controller` class and follow RESTful conventions.

### Public Controllers

#### HomeController
**Purpose**: Display homepage with featured content
```php
class HomeController extends Controller
{
    public function index()
    {
        // Load categories and products
        $categories = Category::active()->take(6)->get();
        $products = Product::featured()->take(8)->get();
        
        return view('home', compact('categories', 'products'));
    }
}
```

#### ProductController
**Purpose**: Product catalog and search functionality
```php
class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Search, filter, and paginate products
        $query = Product::with(['category', 'images'])->active();
        
        // Apply filters
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        
        return view('products.index', [
            'products' => $query->paginate(12),
            'categories' => Category::active()->get()
        ]);
    }
    
    public function show(Product $product)
    {
        // Load product with relationships
        $product->load(['category', 'images']);
        
        return view('products.show', compact('product'));
    }
}
```

#### CategoryController
**Purpose**: Category-based product browsing
```php
class CategoryController extends Controller
{
    public function show(Category $category, Request $request)
    {
        // Get products in this category
        $products = Product::where('category_id', $category->id)
            ->active()
            ->paginate(12);
            
        return view('categories.show', compact('category', 'products'));
    }
}
```

### Authenticated Controllers

#### CartController
**Purpose**: Shopping cart management
```php
class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->price);
        
        return view('cart.index', compact('cartItems', 'total'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:10'
        ]);
        
        // Add or update cart item
        CartItem::updateOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id
        ], [
            'quantity' => $request->quantity,
            'price' => Product::find($request->product_id)->price
        ]);
        
        return back()->with('success', 'Added to cart!');
    }
}
```

#### CheckoutController
**Purpose**: Order processing and payment
```php
class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }
        
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->price);
        $tax = $subtotal * 0.18; // 18% GST
        $shipping = $subtotal > 5000 ? 0 : 200;
        $total = $subtotal + $tax + $shipping;
        
        return view('checkout.index', compact(
            'cartItems', 'subtotal', 'tax', 'shipping', 'total'
        ));
    }
    
    public function process(Request $request)
    {
        // Validate checkout data
        $request->validate([
            'first_name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'payment_method' => 'required|in:cod,online'
        ]);
        
        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD' . time(),
            'total_amount' => $this->calculateTotal(),
            'status' => 'pending',
            'payment_method' => $request->payment_method
        ]);
        
        // Clear cart and redirect
        CartItem::where('user_id', auth()->id())->delete();
        
        return redirect()->route('checkout.success', $order);
    }
}
```

### Admin Controllers

#### Admin\AdminController
**Purpose**: Admin dashboard and analytics
```php
class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_users' => User::where('is_admin', false)->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount')
        ];
        
        $recent_orders = Order::with('user')->latest()->take(10)->get();
        
        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }
}
```

#### Admin\ProductController
**Purpose**: Product CRUD operations
```php
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(20);
        return view('admin.products.index', compact('products'));
    }
    
    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'required'
        ]);
        
        Product::create($request->all());
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }
}
```

## 🔄 Data Processing

### Request Validation
```php
// Example validation rules
$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'price' => 'required|numeric|min:0',
    'category_id' => 'required|exists:categories,id',
    'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
]);
```

### Database Queries
```php
// Efficient queries with relationships
$products = Product::with(['category', 'images'])
    ->where('is_active', true)
    ->whereHas('category', function($q) {
        $q->where('status', 'active');
    })
    ->orderBy('created_at', 'desc')
    ->paginate(12);
```

### Response Handling
```php
// JSON responses for AJAX
public function search(Request $request)
{
    $products = Product::where('name', 'like', "%{$request->q}%")
        ->take(10)
        ->get();
        
    return response()->json([
        'products' => $products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'url' => route('products.show', $product)
            ];
        })
    ]);
}
```

## 🔐 Security Implementation

### Authentication
```php
// Check if user is authenticated
if (!auth()->check()) {
    return redirect()->route('login');
}

// Get current user
$user = auth()->user();
```

### Authorization
```php
// Admin middleware
public function handle($request, Closure $next)
{
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized');
    }
    
    return $next($request);
}

// Owner check
public function show(Order $order)
{
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }
    
    return view('orders.show', compact('order'));
}
```

### CSRF Protection
```html
<!-- All forms include CSRF token -->
<form method="POST" action="{{ route('products.store') }}">
    @csrf
    <!-- form fields -->
</form>
```

## 📊 Error Handling

### Validation Errors
```php
// Display validation errors in views
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

### Custom Error Responses
```php
public function show($id)
{
    $product = Product::find($id);
    
    if (!$product) {
        abort(404, 'Product not found');
    }
    
    return view('products.show', compact('product'));
}
```

## 🔄 Service Integration

### Email Services
```php
// Send order confirmation
Mail::to($order->user->email)
    ->send(new OrderConfirmation($order));
```

### Payment Processing
```php
// Process payment (simplified)
public function processPayment($order, $paymentMethod)
{
    switch ($paymentMethod) {
        case 'stripe':
            return $this->processStripePayment($order);
        case 'razorpay':
            return $this->processRazorpayPayment($order);
        case 'cod':
            return $this->processCOD($order);
    }
}
```

## 📈 Performance Optimization

### Database Optimization
```php
// Eager loading to prevent N+1 queries
$orders = Order::with(['user', 'items.product'])->get();

// Use select to limit columns
$products = Product::select('id', 'name', 'price')->get();

// Cache expensive queries
$categories = Cache::remember('active_categories', 3600, function() {
    return Category::where('status', 'active')->get();
});
```

### Response Optimization
```php
// Return appropriate response types
public function api()
{
    return response()->json($data);
}

public function web()
{
    return view('template', compact('data'));
}
```

---

**Next:** [API Reference →](API.md) | **Previous:** [← Frontend Guide](FRONTEND.md)
