@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
            <p class="text-gray-600 mt-2">Complete your order</p>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Shipping Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Shipping Information</h2>
                        
                        @if($addresses && count($addresses) > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Select Shipping Address</label>
                                <div class="space-y-3">
                                    @foreach($addresses as $address)
                                        <label class="flex items-start space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                            <input type="radio" 
                                                   name="shipping_address_id" 
                                                   value="{{ $address->id }}" 
                                                   class="mt-1 text-blue-600 focus:ring-blue-500"
                                                   {{ $loop->first ? 'checked' : '' }}>
                                            <div class="flex-1">
                                                <div class="font-medium text-gray-900">{{ $address->full_name }}</div>
                                                <div class="text-sm text-gray-600">
                                                    {{ $address->address_line_1 }}<br>
                                                    @if($address->address_line_2)
                                                        {{ $address->address_line_2 }}<br>
                                                    @endif
                                                    {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}<br>
                                                    {{ $address->country }}
                                                </div>
                                                @if($address->phone)
                                                    <div class="text-sm text-gray-600">Phone: {{ $address->phone }}</div>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- New Address Form -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ $addresses && count($addresses) > 0 ? 'Or Add New Address' : 'Shipping Address' }}
                                </h3>
                                @if($addresses && count($addresses) > 0)
                                    <button type="button" 
                                            onclick="toggleNewAddress()"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Add New Address
                                    </button>
                                @endif
                            </div>

                            <div id="new-address-form" class="{{ $addresses && count($addresses) > 0 ? 'hidden' : '' }} space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                        <input type="text" 
                                               name="first_name" 
                                               id="first_name" 
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                        <input type="text" 
                                               name="last_name" 
                                               id="last_name" 
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>

                                <div>
                                    <label for="address_line_1" class="block text-sm font-medium text-gray-700 mb-1">Address Line 1</label>
                                    <input type="text" 
                                           name="address_line_1" 
                                           id="address_line_1" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="address_line_2" class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 (Optional)</label>
                                    <input type="text" 
                                           name="address_line_2" 
                                           id="address_line_2"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                        <input type="text" 
                                               name="city" 
                                               id="city" 
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                                        <input type="text" 
                                               name="state" 
                                               id="state" 
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                        <input type="text" 
                                               name="postal_code" 
                                               id="postal_code" 
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                        <select name="country" 
                                                id="country" 
                                                required
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="India">India</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <input type="tel" 
                                               name="phone" 
                                               id="phone" 
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Billing Information</h2>
                        
                        <div class="mb-4">
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" 
                                       name="billing_same_as_shipping" 
                                       id="billing_same_as_shipping"
                                       checked
                                       onchange="toggleBillingAddress()"
                                       class="text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Billing address same as shipping address</span>
                            </label>
                        </div>

                        <div id="billing-address-form" class="hidden space-y-4">
                            <!-- Billing address form fields (similar to shipping) -->
                            <p class="text-sm text-gray-600">Billing address form would go here...</p>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Payment Method</h2>
                        
                        <div class="space-y-3">
                            <label class="flex items-start space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="cod" 
                                       checked
                                       class="mt-1 text-blue-600 focus:ring-blue-500">
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">Cash on Delivery</div>
                                    <div class="text-sm text-gray-600">Pay when your order is delivered</div>
                                </div>
                                <div class="text-2xl">💵</div>
                            </label>

                            <label class="flex items-start space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="stripe"
                                       class="mt-1 text-blue-600 focus:ring-blue-500">
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">Credit/Debit Card</div>
                                    <div class="text-sm text-gray-600">Secure payment with Stripe</div>
                                </div>
                                <div class="text-2xl">💳</div>
                            </label>

                            <label class="flex items-start space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="razorpay"
                                       class="mt-1 text-blue-600 focus:ring-blue-500">
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">UPI / Net Banking</div>
                                    <div class="text-sm text-gray-600">Pay with Razorpay</div>
                                </div>
                                <div class="text-2xl">📱</div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                        
                        <!-- Order Items -->
                        <div class="space-y-3 mb-6">
                            @foreach($cartItems as $item)
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $item->product->featured_image }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-12 h-12 object-cover rounded-lg">
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                        <div class="text-xs text-gray-500">Qty: {{ $item->quantity }}</div>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        ₹{{ number_format(($item->product->sale_price ?: $item->product->price) * $item->quantity) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="border-t pt-4 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
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
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium">₹{{ number_format($cartTotal * 0.18) }}</span>
                            </div>
                            
                            <div class="border-t pt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total</span>
                                    <span class="text-xl font-bold text-gray-900">
                                        ₹{{ number_format($cartTotal + ($cartTotal >= 5000 ? 0 : 299) + ($cartTotal * 0.18)) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 mt-6">
                            Place Order
                        </button>

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
        </form>
    </div>
</div>

<script>
function toggleNewAddress() {
    const form = document.getElementById('new-address-form');
    form.classList.toggle('hidden');
}

function toggleBillingAddress() {
    const checkbox = document.getElementById('billing_same_as_shipping');
    const form = document.getElementById('billing-address-form');
    
    if (checkbox.checked) {
        form.classList.add('hidden');
    } else {
        form.classList.remove('hidden');
    }
}
</script>
@endsection
