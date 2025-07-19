@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Products</h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                    Discover our premium collection of furniture designed for comfort, style, and durability.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search and Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <form action="{{ route('products.index') }}" method="GET" class="flex">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search products..." 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2 rounded-r-lg hover:bg-blue-700 transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Category Filter -->
                <div class="lg:w-64">
                    <form action="{{ route('products.index') }}" method="GET">
                        <select name="category" 
                                onchange="this.form.submit()"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" 
                                        {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Price Filter -->
                <div class="lg:w-48">
                    <form action="{{ route('products.index') }}" method="GET" class="flex gap-2">
                        <input type="number" 
                               name="min_price" 
                               value="{{ request('min_price') }}"
                               placeholder="Min ₹" 
                               class="w-20 px-2 py-2 border border-gray-300 rounded-lg text-sm">
                        <input type="number" 
                               name="max_price" 
                               value="{{ request('max_price') }}"
                               placeholder="Max ₹" 
                               class="w-20 px-2 py-2 border border-gray-300 rounded-lg text-sm">
                        <button type="submit" class="bg-gray-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-gray-700">
                            Filter
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 overflow-hidden">
                    <!-- Product Image -->
                    <div class="relative">
                        <img src="{{ $product->featured_image }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-48 object-cover">
                        
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-md text-xs font-bold">
                                SALE
                            </div>
                        @endif

                        @if($product->stock_quantity <= 5)
                            <div class="absolute top-2 left-2 bg-orange-500 text-white px-2 py-1 rounded-md text-xs font-bold">
                                Only {{ $product->stock_quantity }} left
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <div class="mb-2">
                            <span class="text-xs text-gray-500 uppercase tracking-wide">{{ $product->category->name }}</span>
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('products.show', $product) }}" class="hover:text-blue-600">
                                {{ $product->name }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                        
                        <!-- Price -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="text-xl font-bold text-red-600">₹{{ number_format($product->sale_price) }}</span>
                                    <span class="text-sm text-gray-500 line-through">₹{{ number_format($product->price) }}</span>
                                @else
                                    <span class="text-xl font-bold text-gray-900">₹{{ number_format($product->price) }}</span>
                                @endif
                            </div>
                            
                            @if($product->stock_quantity > 0)
                                <span class="text-green-600 text-sm font-medium">In Stock</span>
                            @else
                                <span class="text-red-600 text-sm font-medium">Out of Stock</span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('products.show', $product) }}" 
                               class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-center hover:bg-gray-200 transition duration-300">
                                View Details
                            </a>
                            
                            @if($product->stock_quantity > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <button disabled class="flex-1 bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed">
                                    Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-6xl text-gray-300 mb-4">🔍</div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No products found</h3>
                    <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
                    <a href="{{ route('products.index') }}" 
                       class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        View All Products
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(method_exists($products, 'links'))
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
