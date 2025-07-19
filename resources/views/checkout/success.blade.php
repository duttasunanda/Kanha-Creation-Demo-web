@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Success Icon and Message -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Order Placed Successfully!</h1>
            <p class="text-xl text-gray-600">Thank you for your purchase. Your order has been confirmed.</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Order Information -->
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Order Information</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Number:</span>
                            <span class="font-semibold text-gray-900">#{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Date:</span>
                            <span class="font-semibold text-gray-900">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Method:</span>
                            <span class="font-semibold text-gray-900">
                                @if($order->payment_method == 'cod')
                                    Cash on Delivery
                                @elseif($order->payment_method == 'stripe')
                                    Credit/Debit Card
                                @elseif($order->payment_method == 'razorpay')
                                    UPI / Net Banking
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Amount:</span>
                            <span class="text-xl font-bold text-gray-900">₹{{ number_format($order->total_amount) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Shipping Address</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-gray-900 font-semibold mb-2">{{ $order->shipping_address->full_name }}</div>
                        <div class="text-gray-600 text-sm space-y-1">
                            <div>{{ $order->shipping_address->address_line_1 }}</div>
                            @if($order->shipping_address->address_line_2)
                                <div>{{ $order->shipping_address->address_line_2 }}</div>
                            @endif
                            <div>{{ $order->shipping_address->city }}, {{ $order->shipping_address->state }} {{ $order->shipping_address->postal_code }}</div>
                            <div>{{ $order->shipping_address->country }}</div>
                            @if($order->shipping_address->phone)
                                <div class="mt-2">Phone: {{ $order->shipping_address->phone }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="border-t pt-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Order Items</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center space-x-4 py-4 border-b border-gray-200 last:border-b-0">
                            <img src="{{ $item->product->featured_image }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-16 h-16 object-cover rounded-lg">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $item->product->description_short }}</p>
                                <div class="mt-1">
                                    <span class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-gray-900">₹{{ number_format($item->price * $item->quantity) }}</div>
                                <div class="text-sm text-gray-600">₹{{ number_format($item->price) }} each</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="mt-8 bg-gray-50 rounded-lg p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium text-gray-900">₹{{ number_format($order->subtotal) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping:</span>
                            @if($order->shipping_amount > 0)
                                <span class="font-medium text-gray-900">₹{{ number_format($order->shipping_amount) }}</span>
                            @else
                                <span class="font-medium text-green-600">Free</span>
                            @endif
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax:</span>
                            <span class="font-medium text-gray-900">₹{{ number_format($order->tax_amount) }}</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Total:</span>
                                <span class="text-xl font-bold text-gray-900">₹{{ number_format($order->total_amount) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Information -->
        <div class="bg-blue-50 rounded-lg p-6 mb-8">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Delivery Information</h3>
                    <p class="text-blue-800">
                        Your order will be delivered within 7-10 business days. 
                        You will receive a tracking number via email once your order has been shipped.
                    </p>
                    @if($order->payment_method == 'cod')
                        <p class="text-blue-800 mt-2">
                            <strong>Cash on Delivery:</strong> Please keep the exact amount ready for payment upon delivery.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center space-y-4">
            <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('orders.show', $order->id) }}" 
                   class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Track Your Order
                </a>
                <a href="{{ route('products.index') }}" 
                   class="bg-gray-200 text-gray-800 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition duration-300">
                    Continue Shopping
                </a>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('orders.invoice', $order->id) }}" 
                   class="text-blue-600 hover:text-blue-800 font-medium underline">
                    Download Invoice
                </a>
            </div>
        </div>

        <!-- Customer Support -->
        <div class="mt-12 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Need Help?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">Call Us</h4>
                    <p class="text-sm text-gray-600">1800-123-4567</p>
                    <p class="text-xs text-gray-500">Mon-Sat, 9 AM - 6 PM</p>
                </div>
                
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">Email Us</h4>
                    <p class="text-sm text-gray-600">support@nilkamal.com</p>
                    <p class="text-xs text-gray-500">We'll respond within 24 hours</p>
                </div>
                
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">Live Chat</h4>
                    <p class="text-sm text-gray-600">Chat with our team</p>
                    <p class="text-xs text-gray-500">Available 24/7</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
