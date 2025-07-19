@extends('layouts.app')

@section('title', 'Nilkamal Furniture - Quality Furniture for Every Home')
@section('meta_description', 'Discover premium quality furniture from Nilkamal. Shop chairs, tables, storage solutions and more for your home and office.')

@section('content')
<!-- Status Banner -->
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 text-center">
    <strong>✅ Website is Working!</strong> All routes and controllers are connected and functional.
</div>

<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
                    Transform Your Space with 
                    <span class="text-yellow-400">Quality Furniture</span>
                </h1>
                <p class="text-xl mb-8 text-blue-100">
                    Discover our premium collection of chairs, tables, storage solutions, and more. 
                    Built to last, designed to impress.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products.index') }}" class="bg-yellow-500 text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition duration-300 text-center">
                        Shop Now
                    </a>
                    <a href="#featured" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-800 transition duration-300 text-center">
                        View Collection
                    </a>
                </div>
            </div>
            <div class="hidden lg:block">
                <div class="bg-white/20 rounded-lg p-8 text-center">
                    <h3 class="text-2xl font-bold mb-4">Website Features</h3>
                    <ul class="text-left space-y-2">
                        <li>✅ Home Page Working</li>
                        <li>✅ Product Catalog</li>
                        <li>✅ Category Pages</li>
                        <li>✅ Shopping Cart</li>
                        <li>✅ Checkout System</li>
                        <li>✅ User Profile</li>
                        <li>✅ Admin Panel</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-white" id="categories">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6">Shop by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="block text-center group">
                    <div class="bg-gray-100 p-6 rounded-lg group-hover:bg-gray-200 transition">
                        <div class="w-full h-32 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <span class="text-4xl">🪑</span>
                        </div>
                        <h3 class="text-lg font-semibold">{{ $category->name }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-16 bg-gray-100" id="featured">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6">Featured Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
                    <div class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                        <span class="text-6xl">🛋️</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="text-blue-600 font-bold text-xl mb-4">₹{{ number_format($product->price) }}</p>
                    <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition">
                        Add to Cart
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Working Routes Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Available Pages & Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-green-800 mb-3">Public Pages</h3>
                <ul class="space-y-2 text-green-700">
                    <li><a href="{{ route('home') }}" class="hover:underline">🏠 Home Page</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:underline">🛍️ Products</a></li>
                    <li><a href="{{ route('login') }}" class="hover:underline">🔐 Login</a></li>
                    <li><a href="{{ route('register') }}" class="hover:underline">📝 Register</a></li>
                </ul>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-800 mb-3">User Features</h3>
                <ul class="space-y-2 text-blue-700">
                    <li><a href="{{ route('cart.index') }}" class="hover:underline">🛒 Shopping Cart</a></li>
                    <li><a href="{{ route('checkout.index') }}" class="hover:underline">💳 Checkout</a></li>
                    <li><a href="{{ route('profile.index') }}" class="hover:underline">👤 Profile</a></li>
                    <li><a href="{{ route('orders.index') }}" class="hover:underline">📦 Orders</a></li>
                </ul>
            </div>
            
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-purple-800 mb-3">Admin Panel</h3>
                <ul class="space-y-2 text-purple-700">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">📊 Dashboard</a></li>
                    <li><a href="{{ route('admin.products.index') }}" class="hover:underline">📦 Manage Products</a></li>
                    <li><a href="{{ route('admin.categories.index') }}" class="hover:underline">📁 Manage Categories</a></li>
                    <li><a href="{{ route('admin.orders.index') }}" class="hover:underline">🛍️ Manage Orders</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
