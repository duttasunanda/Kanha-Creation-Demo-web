<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Nilkamal Admin</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @yield('head')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white flex-shrink-0">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <h1 class="text-xl font-bold">Nilkamal Admin</h1>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-8">
                <div class="px-4">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" 
                               class="flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-700 transition duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        
                        <!-- Products -->
                        <li x-data="{ open: {{ request()->routeIs('admin.products.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" 
                                    class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700 transition duration-300">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Products
                                </div>
                                <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <ul x-show="open" x-collapse class="ml-8 mt-2 space-y-2">
                                <li>
                                    <a href="{{ route('admin.products.index') }}" 
                                       class="block px-4 py-2 text-sm text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white transition duration-300 {{ request()->routeIs('admin.products.index') ? 'bg-gray-700 text-white' : '' }}">
                                        All Products
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.products.create') }}" 
                                       class="block px-4 py-2 text-sm text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white transition duration-300 {{ request()->routeIs('admin.products.create') ? 'bg-gray-700 text-white' : '' }}">
                                        Add Product
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.categories.index') }}" 
                                       class="block px-4 py-2 text-sm text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white transition duration-300">
                                        Categories
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Orders -->
                        <li>
                            <a href="{{ route('admin.orders.index') }}" 
                               class="flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-700 transition duration-300 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Orders
                                @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
                                    <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $pendingOrdersCount }}</span>
                                @endif
                            </a>
                        </li>
                        
                        <!-- Customers -->
                        <li>
                            <a href="{{ route('admin.customers.index') }}" 
                               class="flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-700 transition duration-300 {{ request()->routeIs('admin.customers.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Customers
                            </a>
                        </li>
                        
                        <!-- Reports -->
                        <li x-data="{ open: {{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" 
                                    class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700 transition duration-300">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Reports
                                </div>
                                <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <ul x-show="open" x-collapse class="ml-8 mt-2 space-y-2">
                                <li>
                                    <a href="{{ route('admin.reports.sales') }}" 
                                       class="block px-4 py-2 text-sm text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white transition duration-300">
                                        Sales Report
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.reports.inventory') }}" 
                                       class="block px-4 py-2 text-sm text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white transition duration-300">
                                        Inventory Report
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.reports.customers') }}" 
                                       class="block px-4 py-2 text-sm text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white transition duration-300">
                                        Customer Report
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Settings -->
                        <li x-data="{ open: {{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" 
                                    class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700 transition duration-300">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Settings
                                </div>
                                <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <ul x-show="open" x-collapse class="ml-8 mt-2 space-y-2">
                                <li>
                                    <a href="{{ route('admin.settings.general') }}" 
                                       class="block px-4 py-2 text-sm text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white transition duration-300">
                                        General
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.settings.shipping') }}" 
                                       class="block px-4 py-2 text-sm text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white transition duration-300">
                                        Shipping
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.settings.payment') }}" 
                                       class="block px-4 py-2 text-sm text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white transition duration-300">
                                        Payment
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                
                <!-- Bottom Menu -->
                <div class="absolute bottom-0 w-64 p-4 border-t border-gray-700">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">A</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Admin User</p>
                            <p class="text-xs text-gray-400">admin@nilkamal.com</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" 
                           class="flex items-center px-3 py-2 text-sm text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white transition duration-300">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View Store
                        </a>
                        <a href="{{ route('auth.logout') }}" 
                           class="flex items-center px-3 py-2 text-sm text-red-400 rounded-lg hover:bg-red-900 hover:text-red-300 transition duration-300">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <button class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <!-- Search -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   placeholder="Search..." 
                                   class="block w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="p-2 text-gray-400 hover:text-gray-500 relative">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 7h6a2 2 0 012 2v9l-3-3H9a2 2 0 01-2-2V9a2 2 0 012-2z"></path>
                                </svg>
                                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-red-400"></span>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <div class="p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-3">Notifications</h3>
                                    <div class="space-y-3">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-2 h-2 bg-blue-400 rounded-full mt-2"></div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-900">New order received</p>
                                                <p class="text-xs text-gray-500">2 minutes ago</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-2 h-2 bg-yellow-400 rounded-full mt-2"></div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-900">Low stock alert: Chair Model A</p>
                                                <p class="text-xs text-gray-500">1 hour ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Profile -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="flex items-center space-x-3 p-2 text-sm rounded-full hover:bg-gray-100">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">A</span>
                                </div>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1">
                                    <a href="{{ route('admin.profile') }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Your Profile
                                    </a>
                                    <a href="{{ route('admin.settings.general') }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Settings
                                    </a>
                                    <a href="{{ route('auth.logout') }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Sign out
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>
