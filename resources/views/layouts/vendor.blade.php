<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vendor Dashboard') - eProShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'Poppins', 'sans-serif'] },
                    colors: {
                        primary: { 
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#FF6600', 
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        },
                        secondary: { 
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', 'Poppins', sans-serif; }
        .sidebar-link.active { background: linear-gradient(to right, #FF6600, #ea580c); color: white; }
        .sidebar-link:not(.active):hover { background-color: #f1f5f9; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Header -->
    <header class="bg-white border-b border-gray-200 fixed top-0 left-0 right-0 z-30">
        <div class="flex items-center justify-between px-6 py-4">
            <!-- Logo & Menu Toggle -->
            <div class="flex items-center space-x-4">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <a href="{{ route('vendor.dashboard') }}" class="flex items-center space-x-3">
                    <!-- Logo Image - Replace with your actual logo -->
                    <img src="{{ asset('images/real_logo_eProShop-removebg-preview.png') }}" alt="eProShop Logo" class="h-10 w-auto" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <!-- Fallback Icon if logo doesn't exist -->
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center" style="display: none;">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-secondary-800">eProShop</h1>
                        <p class="text-xs text-gray-600">Vendor Dashboard</p>
                    </div>
                </a>
            </div>

            <!-- Search Bar (Desktop) -->
            <div class="hidden md:flex flex-1 max-w-lg mx-8">
                <div class="relative w-full">
                    <input type="text" placeholder="Search products, orders..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="relative p-2 rounded-lg hover:bg-gray-100">
                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- User Menu -->
                <div class="relative">
                    <button onclick="toggleUserMenu()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</span>
                        </div>
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-semibold text-secondary-800">{{ Auth::user()->username }}</p>
                            <p class="text-xs text-gray-600">Vendor</p>
                        </div>
                        <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2">
                        <a href="{{ route('vendor.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Settings
                        </a>
                        <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Customer View
                        </a>
                        <hr class="my-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 bottom-0 w-64 bg-white border-r border-gray-200 pt-20 z-20 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <div class="flex flex-col h-full">
            <!-- Vendor Info -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-secondary-800 truncate">{{ $vendor->store_name ?? 'Vendor Store' }}</p>
                        <p class="text-xs text-green-600">● Active</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4">
                <div class="px-4 space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('vendor.dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <!-- Products -->
                    <a href="{{ route('vendor.products.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('vendor.products.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="font-medium">Products</span>
                    </a>

                    <!-- Orders -->
                    <a href="{{ route('vendor.orders.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('vendor.orders.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="font-medium">Orders</span>
                        @if(($pending_orders_count ?? 0) > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">{{ $pending_orders_count }}</span>
                        @endif
                    </a>

                    <!-- Inventory -->
                    <a href="{{ route('vendor.inventory') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('vendor.inventory') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <span class="font-medium">Inventory</span>
                        @if(($low_stock_count ?? 0) > 0)
                        <span class="ml-auto bg-yellow-500 text-white text-xs font-semibold px-2 py-1 rounded-full">{{ $low_stock_count }}</span>
                        @endif
                    </a>

                    <!-- Wallet -->
                    <a href="{{ route('vendor.wallet.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('vendor.wallet.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span class="font-medium">Wallet</span>
                    </a>

                    <!-- Analytics -->
                    <a href="{{ route('vendor.analytics') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('vendor.analytics') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="font-medium">Analytics</span>
                    </a>

                    <hr class="my-4">

                    <!-- Settings -->
                    <a href="{{ route('vendor.settings') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('vendor.settings') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Settings</span>
                    </a>
                </div>
            </nav>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-200">
                <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-4">
                    <p class="text-sm font-semibold text-primary-800 mb-1">Need Help?</p>
                    <p class="text-xs text-primary-700 mb-3">Check our vendor guide</p>
                    <a href="#" class="text-xs font-semibold text-primary-600 hover:text-primary-700">View Guide →</a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-20 min-h-screen">
        <div class="p-6">
            @if(session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
                <div class="mb-6">
                    @if(session()->has('success'))
                        <div class="p-4 rounded-xl bg-green-50 text-green-800 border border-green-200">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session()->has('error'))
                        <div class="p-4 rounded-xl bg-red-50 text-red-800 border border-red-200 mt-2">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session()->has('warning'))
                        <div class="p-4 rounded-xl bg-yellow-50 text-yellow-800 border border-yellow-200 mt-2">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <span>{{ session('warning') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session()->has('info'))
                        <div class="p-4 rounded-xl bg-blue-50 text-blue-800 border border-blue-200 mt-2">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ session('info') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-10 lg:hidden" onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('userMenu');
            const button = event.target.closest('button');
            
            if (!button || !button.onclick || button.onclick.toString().indexOf('toggleUserMenu') === -1) {
                if (menu && !menu.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            }
        });
    </script>
</body>
</html>