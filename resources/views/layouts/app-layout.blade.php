@php
// Using Laravel's session for cart count
$cartCount = session('cart_count', 0);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'eProShop'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.tailwindcss.com"></script>
        <!-- Scripts -->
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Top Bar - Hidden on mobile, visible on tablet+ -->
    <div class="hidden sm:block bg-secondary-800 text-white text-xs sm:text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-2">
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <span class="hidden md:inline">📞 +234 800 123 4567</span>
                    <span class="hidden lg:inline">✉️ hello@eProShop.com</span>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <span class="hidden md:inline">Free shipping on orders over ₦50,000</span>
                    @auth
                        @if(auth()->user()->cooperative_id)
                            <span class="bg-accent-500 text-secondary-800 px-2 py-1 rounded text-xs font-semibold">
                                Cooperative Member
                            </span>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none" 
                            x-data="{ open: false }" 
                            @click="open = !open"
                            aria-controls="mobile-menu" 
                            :aria-expanded="open">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" x-show="!open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-6 w-6" x-show="open" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-primary-600">eProShop</a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'border-b-2 border-primary-500 text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                        Home
                    </a>
                    <a href="{{ route('shop') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('shop') ? 'border-b-2 border-primary-500 text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                        Shop
                    </a>
                    <a href="{{ route('categories.index') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('categories.*') ? 'border-b-2 border-primary-500 text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                        Categories
                    </a>
                    <a href="{{ route('vendors.index') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('vendors.index') ? 'border-b-2 border-primary-500 text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                        Vendors
                    </a>
                    <a href="{{ route('about') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('about') ? 'border-b-2 border-primary-500 text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                        About
                    </a>
                </nav>

                <!-- Right side icons -->
                <div class="flex items-center space-x-4">
                    <!-- Search Form -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" type="button" class="p-2 text-gray-400 hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">Search</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                        
                        <!-- Search Dropdown -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                             style="display: none;">
                            <div class="p-2">
                                <form action="{{ route('shop') }}" method="GET" class="flex">
                                    <input type="text" 
                                           name="search" 
                                           placeholder="Search products..." 
                                           value="{{ request('search') }}"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                           autocomplete="off">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <span class="ml-1">Search</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('wishlist.index') }}" class="p-2 text-gray-400 hover:text-gray-500 relative">
                        <span class="sr-only">Wishlist</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        @auth
                            @php
                                $wishlistCount = auth()->user()->wishlistItems ? auth()->user()->wishlistItems->count() : 0;
                            @endphp
                            @if($wishlistCount > 0)
                                <span class="absolute -top-1 -right-1 bg-primary-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $wishlistCount }}
                                </span>
                            @endif
                        @endauth
                    </a>
                    
                    <a href="{{ route('cart.index') }}" class="p-2 text-gray-400 hover:text-gray-500 relative">
                        <span class="sr-only">Cart</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-primary-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Profile dropdown -->
                    @auth
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" type="button" class="flex text-sm rounded-full focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                </button>
                            </div>
                            
                            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1">Your Orders</a>
                                @if(auth()->user()->isVendor())
                                    <a href="{{ route('vendor.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-2">Vendor Dashboard</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-3">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Sign in</a>
                            <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-md">Sign up</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu" x-show="open" @click.away="open = false" style="display: none;">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 border-primary-500 text-base font-medium text-primary-700 bg-primary-50">
                    Home
                </a>
                <a href="{{ route('shop') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                    Shop
                </a>
                <a href="{{ route('categories.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                    Categories
                </a>
                <a href="{{ route('vendors.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                    Vendors
                </a>
                <a href="{{ route('about') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                    About
                </a>
                
                @guest
                    <div class="pt-4 pb-3 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <a href="{{ route('login') }}" class="block text-base font-medium text-gray-500 hover:text-gray-800">Sign in</a>
                                <a href="{{ route('register') }}" class="block text-sm font-medium text-primary-600 hover:text-primary-500">Create account</a>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Shop</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">All Products</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">Featured</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">New Arrivals</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">Deals & Promotions</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Customer Service</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">Contact Us</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">FAQs</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">Shipping & Returns</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">Track Order</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">About</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">Our Story</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">Careers</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">Terms & Conditions</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-gray-900">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Connect With Us</h3>
                    <div class="mt-4 flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </div>
                    <div class="mt-6">
                        <p class="text-base text-gray-500">Subscribe to our newsletter</p>
                        <form class="mt-2 sm:flex">
                            <label for="email-address" class="sr-only">Email address</label>
                            <input id="email-address" name="email" type="email" autocomplete="email" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" placeholder="Enter your email">
                            <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3 sm:flex-shrink-0">
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Subscribe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-8 md:flex md:items-center md:justify-between">
                <div class="flex space-x-6 md:order-2">
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Privacy</span>
                        <span class="text-sm text-gray-500">Privacy Policy</span>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Terms</span>
                        <span class="text-sm text-gray-500">Terms of Service</span>
                    </a>
                </div>
                <p class="mt-8 text-base text-gray-400 md:mt-0 md:order-1">
                    &copy; {{ date('Y') }} eProShop. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    @stack('modals')
    @stack('scripts')
</body>
</html>
