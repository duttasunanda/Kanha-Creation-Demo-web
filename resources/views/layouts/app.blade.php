<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/../../../bootstrap/helpers.php'; ?>DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Nilkamal Furniture - Quality Furniture for Every Home')</title>
    <meta name="description" content="@yield('meta_description', 'Discover premium quality furniture from Nilkamal. Shop chairs, tables, storage solutions and more for your home and office.')">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="Nilkamal Furniture">
                        <span class="ml-2 text-xl font-bold text-blue-600">Nilkamal</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                            Home
                        </a>
                        <a href="{{ route('products.index') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('products.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                            Products
                        </a>
                        
                        <!-- Categories Dropdown -->
                        <div class="relative group">
                            <button class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 inline-flex items-center">
                                Categories
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                                <div class="py-1">
                                    @foreach(\App\Models\Category::active()->parents()->get() as $category)
                                        <a href="{{ route('categories.show', $category->slug) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="hidden md:block flex-1 max-w-xs mx-8">
                    <form action="{{ route('products.index') }}" method="GET" class="relative">
                        <input type="text" name="search" placeholder="Search products..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ request('search') }}">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </form>
                </div>

                <!-- Right side menu -->
                <div class="flex items-center space-x-4">
                    <!-- Cart -->
                    @auth
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-blue-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13v6a1 1 0 001 1h8a1 1 0 001-1v-6m-9 0h10" />
                            </svg>
                            @if(auth()->user()->cart_quantity > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ auth()->user()->cart_quantity }}
                                </span>
                            @endif
                        </a>
                    @endauth

                    <!-- User Menu -->
                    @auth
                        <div class="relative group">
                            <button class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                                <div class="py-1">
                                    <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Panel</a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Sign Up</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="mobile-menu-button p-2 rounded-md text-gray-700 hover:text-blue-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="mobile-menu hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">Home</a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">Products</a>
                @auth
                    <a href="{{ route('cart.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">Cart</a>
                    <a href="{{ route('profile.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">Profile</a>
                    <a href="{{ route('orders.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">My Orders</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">Login</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">Sign Up</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1">
                    <div class="flex items-center mb-4">
                        <img class="h-8 w-auto" src="{{ asset('images/logo-white.png') }}" alt="Nilkamal Furniture">
                        <span class="ml-2 text-xl font-bold">Nilkamal</span>
                    </div>
                    <p class="text-gray-300 text-sm">
                        Quality furniture for every home. Creating comfortable living spaces with style and durability.
                    </p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-300 hover:text-white">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white text-sm">Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white text-sm">Products</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Contact</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">FAQ</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4">Categories</h3>
                    <ul class="space-y-2">
                        @foreach(\App\Models\Category::active()->parents()->limit(5)->get() as $category)
                            <li><a href="{{ route('categories.show', $category->slug) }}" class="text-gray-300 hover:text-white text-sm">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4">Contact</h3>
                    <div class="space-y-2 text-sm text-gray-300">
                        <p>📞 +91 1234567890</p>
                        <p>✉️ info@nilkamal.com</p>
                        <p>📍 Mumbai, Maharashtra, India</p>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300 text-sm">
                    © {{ date('Y') }} Nilkamal Furniture. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('.mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
