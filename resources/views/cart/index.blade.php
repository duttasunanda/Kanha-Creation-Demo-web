@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
            <p class="text-gray-600 mt-2">Review your items before checkout</p>
        </div>

        @if($cartItems && count($cartItems) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Cart Items ({{ $cartQuantity }})</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <div class="p-6">
                                    <div class="flex items-center space-x-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            <img src="{{ $item->product->featured_image }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        </div>

                                        <!-- Product Info -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                <a href="{{ route('products.show', $item->product) }}" class="hover:text-blue-600">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-500">{{ $item->product->category->name }}</p>
                                            
                                            <!-- Price -->
                                            <div class="flex items-center space-x-2 mt-1">
                                                @if($item->product->sale_price && $item->product->sale_price < $item->product->price)
                                                    <span class="text-lg font-bold text-red-600">₹{{ number_format($item->product->sale_price) }}</span>
                                                    <span class="text-sm text-gray-500 line-through">₹{{ number_format($item->product->price) }}</span>
                                                @else
                                                    <span class="text-lg font-bold text-gray-900">₹{{ number_format($item->product->price) }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Quantity Controls -->
                                        <div class="flex items-center space-x-2">
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="flex items-center border border-gray-300 rounded-lg">
                                                    <button type="button" 
                                                            onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                            class="px-3 py-1 text-gray-600 hover:text-gray-800 {{ $item->quantity <= 1 ? 'cursor-not-allowed opacity-50' : '' }}"
                                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        -
                                                    </button>
                                                    <span class="px-3 py-1 text-center min-w-[3rem]">{{ $item->quantity }}</span>
                                                    <button type="button" 
                                                            onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                            class="px-3 py-1 text-gray-600 hover:text-gray-800">
                                                        +
                                                    </button>
                                                </div>
                                            </form>

                                            <!-- Remove Item -->
                                            <form action="{{ route('cart.remove', $item) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Remove this item from cart?')"
                                                        class="text-red-600 hover:text-red-800 p-1">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Item Total -->
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-gray-900">
                                                ₹{{ number_format(($item->product->sale_price ?: $item->product->price) * $item->quantity) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Cart Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Clear all items from cart?')"
                                            class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Clear Cart
                                    </button>
                                </form>

                                <a href="{{ route('products.index') }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal ({{ $cartQuantity }} items)</span>
                                <span class="font-medium">₹{{ number_format($cartTotal) }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                @if($cartTotal >= 5000)
                                    <span class="font-medium text-green-600">Free</span>
                                @else
                                    <span class="font-medium">₹299</span>
                                @endif
                            </div>
                            
                            @if($cartTotal < 5000)
                                <div class="text-sm text-blue-600 bg-blue-50 p-3 rounded-lg">
                                    Add ₹{{ number_format(5000 - $cartTotal) }} more for free shipping!
                                </div>
                            @endif
                            
                            <div class="border-t pt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total</span>
                                    <span class="text-xl font-bold text-gray-900">
                                        ₹{{ number_format($cartTotal + ($cartTotal >= 5000 ? 0 : 299)) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3">
                            @auth
                                <a href="{{ route('checkout.index') }}" 
                                   class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 text-center block">
                                    Proceed to Checkout
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 text-center block">
                                    Login to Checkout
                                </a>
                            @endauth
                            
                            <button class="w-full border border-gray-300 text-gray-700 py-3 px-4 rounded-lg font-semibold hover:bg-gray-50 transition duration-300">
                                Save for Later
                            </button>
                        </div>

                        <!-- Trust Signals -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="grid grid-cols-1 gap-3 text-sm text-gray-600">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Secure checkout</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Free returns within 30 days</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>5 year warranty</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="text-6xl text-gray-300 mb-4">🛒</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
                <p class="text-gray-600 mb-8">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function updateQuantity(itemId, newQuantity) {
    if (newQuantity < 1) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/cart/update/${itemId}`;
    
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PUT';
    
    const tokenInput = document.createElement('input');
    tokenInput.type = 'hidden';
    tokenInput.name = '_token';
    tokenInput.value = '{{ csrf_token() }}';
    
    const quantityInput = document.createElement('input');
    quantityInput.type = 'hidden';
    quantityInput.name = 'quantity';
    quantityInput.value = newQuantity;
    
    form.appendChild(methodInput);
    form.appendChild(tokenInput);
    form.appendChild(quantityInput);
    
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection
