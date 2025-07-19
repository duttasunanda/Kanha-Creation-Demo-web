@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                </li>
                <li>
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700">Products</a>
                </li>
                <li>
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-gray-900 font-medium">{{ $product->name }}</span>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                <!-- Product Images -->
                <div class="space-y-4">
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                        <img src="{{ $product->featured_image }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                    
                    @if($product->images && count($product->images) > 1)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($product->images as $image)
                                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:opacity-75">
                                    <img src="{{ $image->image_path }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <!-- Category & Availability -->
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $product->category->name }}
                        </span>
                        
                        @if($product->stock_quantity > 0)
                            <span class="text-green-600 font-medium">✓ In Stock ({{ $product->stock_quantity }} available)</span>
                        @else
                            <span class="text-red-600 font-medium">✗ Out of Stock</span>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>

                    <!-- Price -->
                    <div class="flex items-center space-x-4">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="text-3xl font-bold text-red-600">₹{{ number_format($product->sale_price) }}</span>
                            <span class="text-xl text-gray-500 line-through">₹{{ number_format($product->price) }}</span>
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-md text-sm font-bold">
                                {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                            </span>
                        @else
                            <span class="text-3xl font-bold text-gray-900">₹{{ number_format($product->price) }}</span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="prose prose-sm max-w-none">
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- Product Details -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Details</h3>
                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">SKU</dt>
                                <dd class="text-sm text-gray-900">{{ $product->sku ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd class="text-sm text-gray-900">{{ $product->category->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Dimensions</dt>
                                <dd class="text-sm text-gray-900">{{ $product->dimensions ?? 'Not specified' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Weight</dt>
                                <dd class="text-sm text-gray-900">{{ $product->weight ?? 'Not specified' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Add to Cart -->
                    @if($product->stock_quantity > 0)
                        <div class="border-t pt-6">
                            <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="flex items-center space-x-4">
                                    <label for="quantity" class="text-sm font-medium text-gray-700">Quantity:</label>
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button" 
                                                onclick="decrementQuantity()" 
                                                class="px-3 py-2 text-gray-600 hover:text-gray-800">-</button>
                                        <input type="number" 
                                               name="quantity" 
                                               id="quantity" 
                                               value="1" 
                                               min="1" 
                                               max="{{ $product->stock_quantity }}"
                                               class="w-16 text-center border-0 focus:ring-0">
                                        <button type="button" 
                                                onclick="incrementQuantity()" 
                                                class="px-3 py-2 text-gray-600 hover:text-gray-800">+</button>
                                    </div>
                                </div>

                                <div class="flex space-x-4">
                                    <button type="submit" 
                                            class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                                        Add to Cart
                                    </button>
                                    <button type="button" 
                                            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="border-t pt-6">
                            <button disabled class="w-full bg-gray-300 text-gray-500 py-3 px-6 rounded-lg font-semibold cursor-not-allowed">
                                Out of Stock
                            </button>
                        </div>
                    @endif

                    <!-- Features -->
                    <div class="border-t pt-6">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div class="text-sm">
                                <div class="text-blue-600 mb-2">🚚</div>
                                <div class="font-medium">Free Delivery</div>
                                <div class="text-gray-500">Orders above ₹5,000</div>
                            </div>
                            <div class="text-sm">
                                <div class="text-blue-600 mb-2">🔧</div>
                                <div class="font-medium">Free Assembly</div>
                                <div class="text-gray-500">Professional setup</div>
                            </div>
                            <div class="text-sm">
                                <div class="text-blue-600 mb-2">🛡️</div>
                                <div class="font-medium">5 Year Warranty</div>
                                <div class="text-gray-500">Quality guarantee</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts && count($relatedProducts) > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 overflow-hidden">
                            <div class="aspect-square bg-gray-100">
                                <img src="{{ $relatedProduct->featured_image }}" 
                                     alt="{{ $relatedProduct->name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2">
                                    <a href="{{ route('products.show', $relatedProduct) }}" class="hover:text-blue-600">
                                        {{ $relatedProduct->name }}
                                    </a>
                                </h3>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-gray-900">₹{{ number_format($relatedProduct->price) }}</span>
                                    <a href="{{ route('products.show', $relatedProduct) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.getAttribute('min'));
    const current = parseInt(input.value);
    if (current > min) {
        input.value = current - 1;
    }
}
</script>
@endsection
