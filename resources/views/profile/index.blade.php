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
                           class="flex items-center space-x-3 px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('profile.index') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Profile</span>
                        </a>
                        
                        <a href="{{ route('orders.index') }}" 
                           class="flex items-center space-x-3 px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100">
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
                <div class="bg-white rounded-lg shadow-md">
                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h1 class="text-2xl font-semibold text-gray-900">Profile Information</h1>
                        <p class="text-gray-600 mt-1">Update your account details and preferences</p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                        @csrf
                        @method('PUT')

                        <!-- Profile Picture -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-4">Profile Picture</label>
                            <div class="flex items-center space-x-6">
                                <div class="w-24 h-24 bg-gray-100 rounded-full overflow-hidden">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}" alt="Profile" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
                                    <label for="avatar" class="bg-blue-600 text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-blue-700 transition duration-300">
                                        Change Picture
                                    </label>
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF. Max size 2MB.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" 
                                       name="first_name" 
                                       id="first_name" 
                                       value="{{ $user->first_name }}" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" 
                                       name="last_name" 
                                       id="last_name" 
                                       value="{{ $user->last_name }}" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ $user->email }}" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" 
                                       name="phone" 
                                       id="phone" 
                                       value="{{ $user->phone }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                <input type="date" 
                                       name="date_of_birth" 
                                       id="date_of_birth" 
                                       value="{{ $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                <select name="gender" 
                                        id="gender"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                                    <option value="prefer_not_to_say" {{ $user->gender == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                </select>
                            </div>
                        </div>

                        <!-- Preferences -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Preferences</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           name="newsletter_subscription" 
                                           id="newsletter_subscription" 
                                           {{ $user->newsletter_subscription ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="newsletter_subscription" class="ml-3 text-sm text-gray-700">
                                        Subscribe to newsletter for exclusive offers and updates
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           name="sms_notifications" 
                                           id="sms_notifications" 
                                           {{ $user->sms_notifications ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="sms_notifications" class="ml-3 text-sm text-gray-700">
                                        Receive SMS notifications for order updates
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                Save Changes
                            </button>
                            
                            <a href="{{ route('profile.change-password') }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                Change Password
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Account Statistics -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow-md p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $stats['total_orders'] }}</div>
                        <div class="text-gray-600">Total Orders</div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6 text-center">
                        <div class="text-3xl font-bold text-green-600 mb-2">₹{{ number_format($stats['total_spent']) }}</div>
                        <div class="text-gray-600">Total Spent</div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">{{ $stats['wishlist_items'] }}</div>
                        <div class="text-gray-600">Wishlist Items</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
