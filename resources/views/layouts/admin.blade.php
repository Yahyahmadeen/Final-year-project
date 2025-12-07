<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('extra_head')
</head>
<body class="bg-secondary-50">
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
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 w-64 bg-secondary-900 text-white z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 bg-secondary-800 border-b border-secondary-700">
            <h1 class="text-2xl font-bold text-primary-400">{{ config('app.name') }} Admin</h1>
        </div>

        <!-- Navigation -->
        <nav class="mt-6 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-secondary-800 transition @if(request()->routeIs('admin.dashboard')) bg-secondary-800 border-l-4 border-primary-500 @endif">
                <i class="fas fa-chart-line w-5"></i>
                <span class="ml-3">Dashboard</span>
            </a>

            <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-secondary-800 transition @if(request()->routeIs('admin.users')) bg-secondary-800 border-l-4 border-primary-500 @endif">
                <i class="fas fa-users w-5"></i>
                <span class="ml-3">Users</span>
            </a>


            <a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-secondary-800 transition @if(request()->routeIs('admin.products')) bg-secondary-800 border-l-4 border-primary-500 @endif">
                <i class="fas fa-box w-5"></i>
                <span class="ml-3">Products</span>
            </a>

            <a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-secondary-800 transition @if(request()->routeIs('admin.orders')) bg-secondary-800 border-l-4 border-primary-500 @endif">
                <i class="fas fa-shopping-cart w-5"></i>
                <span class="ml-3">Orders</span>
            </a>

            <a href="{{ route('admin.payments') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-secondary-800 transition @if(request()->routeIs('admin.payments')) bg-secondary-800 border-l-4 border-primary-500 @endif">
                <i class="fas fa-credit-card w-5"></i>
                <span class="ml-3">Payments</span>
            </a>

            <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-secondary-800 transition @if(request()->routeIs('admin.reports')) bg-secondary-800 border-l-4 border-primary-500 @endif">
                <i class="fas fa-chart-bar w-5"></i>
                <span class="ml-3">Reports</span>
            </a>

            <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-secondary-800 transition @if(request()->routeIs('admin.settings')) bg-secondary-800 border-l-4 border-primary-500 @endif">
                <i class="fas fa-cog w-5"></i>
                <span class="ml-3">Settings</span>
            </a>

            <div class="border-t border-secondary-700 my-4"></div>

            <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 transition">
                <i class="fas fa-home w-5"></i>
                <span class="ml-3">Back to Site</span>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm border-b border-secondary-200 sticky top-0 z-40">
            <div class="flex items-center justify-between px-8 py-4">
                <div class="flex items-center space-x-4">
                    <h2 class="text-2xl font-bold text-secondary-800">@yield('page_title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center space-x-6">
                    <!-- Notifications -->
                    <button class="relative text-secondary-600 hover:text-secondary-800">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                    </button>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-3">
                        <div class="text-right">
                            <p class="text-sm font-semibold text-secondary-800">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-secondary-500">Administrator</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Messages -->
        @if(session('success'))
        <div class="px-8 py-4">
            <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Page Content -->
        <main class="p-8">
            @yield('content')
        </main>
    </div>

    @stack('extra_scripts')
</body>
</html>
