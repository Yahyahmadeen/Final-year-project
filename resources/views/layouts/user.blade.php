<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - User Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    
    <!-- Heroicons -->
    <script src="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/outline.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen" 
             class="lg:hidden fixed inset-0 bg-gray-600 bg-opacity-75 z-40"
             @click="sidebarOpen = false">
        </div>

        <!-- Sidebar -->
        <div class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64 bg-indigo-700">
                <div class="flex-1 flex flex-col pt-5 pb-4">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <a href="{{ route('home') }}" class="text-white text-2xl font-bold">
                            {{ config('app.name') }}
                        </a>
                    </div>
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-2 py-2 text-sm font-medium rounded-md text-white bg-indigo-800 group">
                            <i class="hi-outline hi-home mr-3 h-6 w-6"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('orders.index') }}" 
                           class="flex items-center px-2 py-2 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600 group">
                            <i class="hi-outline hi-shopping-bag mr-3 h-6 w-6"></i>
                            My Orders
                        </a>
                        <a href="{{ route('wishlist.index') }}" 
                           class="flex items-center px-2 py-2 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600 group">
                            <i class="hi-outline hi-heart mr-3 h-6 w-6"></i>
                            Wishlist
                        </a>
                        <a href="{{ route('profile.show') }}" 
                           class="flex items-center px-2 py-2 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600 group">
                            <i class="hi-outline hi-user mr-3 h-6 w-6"></i>
                            My Profile
                        </a>
                        <a href="{{ route('addresses.index') }}" 
                           class="flex items-center px-2 py-2 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600 group">
                            <i class="hi-outline hi-location-marker mr-3 h-6 w-6"></i>
                            My Addresses
                        </a>
                    </nav>
                </div>
                <div class="flex-shrink-0 p-4 border-t border-indigo-800">
                    <a href="{{ route('profile.show') }}" class="flex items-center group">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" 
                                 src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                 alt="{{ auth()->user()->name }}">
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs font-medium text-indigo-200 group-hover:text-white">View profile</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 transform lg:hidden"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
             x-transition>
            <div class="flex flex-col h-full bg-indigo-700">
                <div class="flex-1 flex flex-col pt-5 pb-4">
                    <div class="flex items-center justify-between px-4">
                        <a href="{{ route('home') }}" class="text-white text-2xl font-bold">
                            {{ config('app.name') }}
                        </a>
                        <button @click="sidebarOpen = false" class="text-indigo-200 hover:text-white">
                            <i class="hi-outline hi-x h-6 w-6"></i>
                        </button>
                    </div>
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-2 py-2 text-base font-medium rounded-md text-white bg-indigo-800 group">
                            <i class="hi-outline hi-home mr-3 h-6 w-6"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('orders.index') }}" 
                           class="flex items-center px-2 py-2 text-base font-medium rounded-md text-indigo-100 hover:bg-indigo-600 group">
                            <i class="hi-outline hi-shopping-bag mr-3 h-6 w-6"></i>
                            My Orders
                        </a>
                        <a href="{{ route('wishlist.index') }}" 
                           class="flex items-center px-2 py-2 text-base font-medium rounded-md text-indigo-100 hover:bg-indigo-600 group">
                            <i class="hi-outline hi-heart mr-3 h-6 w-6"></i>
                            Wishlist
                        </a>
                        <a href="{{ route('profile.show') }}" 
                           class="flex items-center px-2 py-2 text-base font-medium rounded-md text-indigo-100 hover:bg-indigo-600 group">
                            <i class="hi-outline hi-user mr-3 h-6 w-6"></i>
                            My Profile
                        </a>
                        <a href="{{ route('addresses.index') }}" 
                           class="flex items-center px-2 py-2 text-base font-medium rounded-md text-indigo-100 hover:bg-indigo-600 group">
                            <i class="hi-outline hi-location-marker mr-3 h-6 w-6"></i>
                            My Addresses
                        </a>
                    </nav>
                </div>
                <div class="flex-shrink-0 p-4 border-t border-indigo-800">
                    <a href="{{ route('profile.show') }}" class="flex items-center group">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" 
                                 src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                 alt="{{ auth()->user()->name }}">
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs font-medium text-indigo-200 group-hover:text-white">View profile</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top navigation -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center lg:hidden">
                            <button @click="sidebarOpen = true" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                <i class="hi-outline hi-menu h-6 w-6"></i>
                            </button>
                        </div>
                        <div class="flex-1 flex justify-end items-center">
                            <div class="text-sm text-gray-500 mr-4 hidden sm:block">
                                {{ now()->format('l, F j, Y') }}
                            </div>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" type="button" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ auth()->user()->name }}">
                                </button>
                                
                                <!-- Profile dropdown -->
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                     role="menu"
                                     aria-orientation="vertical"
                                     aria-labelledby="user-menu">
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        Your Profile
                                    </a>
                                    <a href="{{ route('profile.show') }}#settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        Settings
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>