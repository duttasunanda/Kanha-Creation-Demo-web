@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover">
                            @else
                                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            @endif
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    </div>
                    
                    <nav class="space-y-2">
                        <a href="{{ route('profile.index') }}" 
                           class="flex items-center space-x-3 px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Profile</span>
                        </a>
                        
                        <a href="{{ route('orders.index') }}" 
                           class="flex items-center space-x-3 px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('orders.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span>Orders</span>
                        </a>
                        
                        <a href="{{ route('profile.addresses') }}" 
                           class="flex items-center space-x-3 px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Addresses</span>
                        </a>
                        
                        <a href="{{ route('profile.wishlist') }}" 
                           class="flex items-center space-x-3 px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span>Wishlist</span>
                        </a>
                        
                        <a href="{{ route('profile.settings') }}" 
                           class="flex items-center space-x-3 px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Settings</span>
                        </a>
                        
                        <a href="{{ route('auth.logout') }}" 
                           class="flex items-center space-x-3 px-3 py-2 text-red-600 rounded-lg hover:bg-red-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Header -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">My Orders</h1>
                            <p class="text-gray-600 mt-1">Track and manage your orders</p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-600">Total Orders</div>
                            <div class="text-2xl font-bold text-blue-600">{{ count($orders) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="bg-white rounded-lg shadow-md mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="flex space-x-8 px-6" aria-label="Tabs">
                            <a href="{{ route('orders.index') }}" 
                               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ !request('status') ? 'border-blue-500 text-blue-600' : '' }}">
                                All Orders
                            </a>
                            <a href="{{ route('orders.index', ['status' => 'pending']) }}" 
                               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('status') == 'pending' ? 'border-blue-500 text-blue-600' : '' }}">
                                Pending
                            </a>
                            <a href="{{ route('orders.index', ['status' => 'processing']) }}" 
                               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('status') == 'processing' ? 'border-blue-500 text-blue-600' : '' }}">
                                Processing
                            </a>
                            <a href="{{ route('orders.index', ['status' => 'shipped']) }}" 
                               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('status') == 'shipped' ? 'border-blue-500 text-blue-600' : '' }}">
                                Shipped
                            </a>
                            <a href="{{ route('orders.index', ['status' => 'delivered']) }}" 
                               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('status') == 'delivered' ? 'border-blue-500 text-blue-600' : '' }}">
                                Delivered
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Orders List -->
                @if(count($orders) > 0)
                    <div class="space-y-6">
                        @foreach($orders as $order)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <!-- Order Header -->
                                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Order #{{ $order->order_number }}</div>
                                                <div class="text-sm text-gray-500">Placed on {{ $order->created_at->format('M d, Y') }}</div>
                                            </div>
                                            <div class="flex items-center">
                                                @if($order->status == 'pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @elseif($order->status == 'processing')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Processing
                                                    </span>
                                                @elseif($order->status == 'shipped')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        Shipped
                                                    </span>
                                                @elseif($order->status == 'delivered')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Delivered
                                                    </span>
                                                @elseif($order->status == 'cancelled')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Cancelled
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="text-right">
                                            <div class="text-lg font-semibold text-gray-900">₹{{ number_format($order->total_amount) }}</div>
                                            <div class="text-sm text-gray-500">{{ count($order->items) }} {{ count($order->items) == 1 ? 'item' : 'items' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Items -->
                                <div class="p-6">
                                    <div class="space-y-4">
                                        @foreach($order->items as $item)
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ $item->product->featured_image }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="w-16 h-16 object-cover rounded-lg">
                                                <div class="flex-1">
                                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                                                    <p class="text-sm text-gray-500">{{ $item->product->description_short }}</p>
                                                    <div class="mt-1 flex items-center space-x-4">
                                                        <span class="text-sm text-gray-500">Qty: {{ $item->quantity }}</span>
                                                        <span class="text-sm font-medium text-gray-900">₹{{ number_format($item->price) }} each</span>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-medium text-gray-900">₹{{ number_format($item->price * $item->quantity) }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Order Actions -->
                                    <div class="mt-6 pt-6 border-t border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4">
                                                @if($order->status == 'shipped' && $order->tracking_number)
                                                    <div class="text-sm text-gray-600">
                                                        Tracking: <span class="font-medium">{{ $order->tracking_number }}</span>
                                                    </div>
                                                @endif
                                                
                                                @if($order->status == 'delivered' && $order->delivered_at)
                                                    <div class="text-sm text-green-600">
                                                        Delivered on {{ $order->delivered_at->format('M d, Y') }}
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('orders.show', $order->id) }}" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    View Details
                                                </a>
                                                
                                                @if($order->status == 'delivered')
                                                    <a href="{{ route('orders.invoice', $order->id) }}" 
                                                       class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                        Download Invoice
                                                    </a>
                                                @endif
                                                
                                                @if(in_array($order->status, ['pending', 'processing']))
                                                    <button onclick="cancelOrder({{ $order->id }})" 
                                                            class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                        Cancel Order
                                                    </button>
                                                @endif
                                                
                                                @if($order->status == 'delivered')
                                                    <a href="{{ route('orders.reorder', $order->id) }}" 
                                                       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition duration-300">
                                                        Reorder
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if(isset($pagination) && $pagination['total_pages'] > 1)
                        <div class="mt-8 flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Showing {{ $pagination['from'] }} to {{ $pagination['to'] }} of {{ $pagination['total'] }} results
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                @if($pagination['current_page'] > 1)
                                    <a href="{{ route('orders.index', array_merge(request()->all(), ['page' => $pagination['current_page'] - 1])) }}" 
                                       class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                        Previous
                                    </a>
                                @endif
                                
                                @for($i = 1; $i <= $pagination['total_pages']; $i++)
                                    @if($i == $pagination['current_page'])
                                        <span class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg">
                                            {{ $i }}
                                        </span>
                                    @else
                                        <a href="{{ route('orders.index', array_merge(request()->all(), ['page' => $i])) }}" 
                                           class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                            {{ $i }}
                                        </a>
                                    @endif
                                @endfor
                                
                                @if($pagination['current_page'] < $pagination['total_pages'])
                                    <a href="{{ route('orders.index', array_merge(request()->all(), ['page' => $pagination['current_page'] + 1])) }}" 
                                       class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                        Next
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="mt-6 text-lg font-medium text-gray-900">No orders found</h3>
                        <p class="mt-2 text-gray-500">You haven't placed any orders yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('products.index') }}" 
                               class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                                Start Shopping
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Cancel Order</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to cancel this order? This action cannot be undone.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="cancelConfirm" 
                        class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                    Cancel Order
                </button>
                <button onclick="closeCancelModal()" 
                        class="mt-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Keep Order
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let orderToCancel = null;

function cancelOrder(orderId) {
    orderToCancel = orderId;
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    orderToCancel = null;
}

document.getElementById('cancelConfirm').addEventListener('click', function() {
    if (orderToCancel) {
        // Here you would make an AJAX request to cancel the order
        console.log('Cancelling order:', orderToCancel);
        
        // For demo purposes, just close the modal
        closeCancelModal();
        
        // In a real app, you would:
        // fetch(`/orders/${orderToCancel}/cancel`, {
        //     method: 'POST',
        //     headers: {
        //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        //         'Content-Type': 'application/json'
        //     }
        // }).then(response => {
        //     if (response.ok) {
        //         location.reload();
        //     }
        // });
    }
});
</script>
@endsection
