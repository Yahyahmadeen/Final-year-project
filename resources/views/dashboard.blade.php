@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r bg-primary-600 to-primary-700 rounded-2xl shadow-xl overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-white/10 p-3 rounded-xl backdrop-blur-sm">
                        <i class="hi-outline hi-sparkles h-8 w-8 text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-white">Welcome back, {{ $user->name }}!</h2>
                        <p class="mt-1 text-primary-100">Here's what's happening with your account today.</p>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-primary-700 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <i class="hi-outline hi-shopping-cart -ml-1 mr-2 h-5 w-5"></i>
                        Start Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Orders Card -->
        <div class="bg-white overflow-hidden shadow rounded-xl hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-primary-100 p-3 rounded-xl">
                        <i class="hi-outline hi-shopping-bag h-6 w-6 text-primary-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalOrders ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3 text-right border-t border-gray-100">
                <a href="{{ route('orders.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 flex items-center justify-end">
                    View all
                    <i class="hi-outline hi-arrow-right ml-1 h-4 w-4"></i>
                </a>
            </div>
        </div>

        <!-- Pending Orders Card -->
        <div class="bg-white overflow-hidden shadow rounded-xl hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 p-3 rounded-xl">
                        <i class="hi-outline hi-clock h-6 w-6 text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Pending Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingOrders ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3 text-right border-t border-gray-100">
                <a href="{{ route('orders.index', ['status' => 'pending,processing']) }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 flex items-center justify-end">
                    View all
                    <i class="hi-outline hi-arrow-right ml-1 h-4 w-4"></i>
                </a>
            </div>
        </div>

        <!-- Wishlist Card -->
        <div class="bg-white overflow-hidden shadow rounded-xl hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 p-3 rounded-xl">
                        <i class="hi-outline hi-heart h-6 w-6 text-red-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Items in Wishlist</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $wishlistCount }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3 text-right border-t border-gray-100">
                <a href="{{ route('wishlist.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 flex items-center justify-end">
                    View all
                    <i class="hi-outline hi-arrow-right ml-1 h-4 w-4"></i>
                </a>
            </div>
        </div>

        <!-- Wallet Balance Card -->
        <div class="bg-white overflow-hidden shadow rounded-xl hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 p-3 rounded-xl">
                        <i class="hi-outline hi-wallet h-6 w-6 text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Wallet Balance</p>
                        <p class="text-2xl font-bold text-gray-900">₦{{ number_format($walletBalance, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3 text-right border-t border-gray-100">
                <div class="flex space-x-2">
                    <a href="{{ route('wallet.index') }}" class="px-3 py-1 text-sm bg-primary-100 text-primary-700 rounded-full hover:bg-primary-200">Fund Wallet</a>
                    <a href="{{ route('wallet.index') }}" class="px-3 py-1 text-sm bg-secondary-100 text-secondary-700 rounded-full hover:bg-secondary-200">Withdraw</a>
                </div>
            </div>
        </div>

        <!-- Account Card -->
        <div class="bg-white overflow-hidden shadow rounded-xl hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 p-3 rounded-xl">
                        <i class="hi-outline hi-user-circle h-6 w-6 text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Member Since</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $user->created_at->format('M Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3 text-right border-t border-gray-100">
                <a href="{{ route('profile.show') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 flex items-center justify-end">
                    View Profile
                    <i class="hi-outline hi-arrow-right ml-1 h-4 w-4"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders Panel -->
        <div class="bg-white shadow-lg overflow-hidden rounded-2xl border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <i class="hi-outline hi-shopping-bag h-5 w-5 text-primary-600 mr-2"></i>
                        Recent Orders
                    </h3>
                    <a href="{{ route('orders.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 flex items-center">
                        View All
                        <i class="hi-outline hi-arrow-right ml-1 h-4 w-4"></i>
                    </a>
                </div>
            </div>
            
            @if(isset($recentOrders) && $recentOrders->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($recentOrders as $order)
                        <li class="hover:bg-gray-50 transition-colors duration-150">
                            <a href="{{ route('orders.show', $order) }}" class="block px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-primary-600 truncate">Order #{{ $order->order_number }}</p>
                                            <div class="ml-2 flex-shrink-0">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'processing' => 'bg-primary-100 text-primary-800',
                                                        'shipped' => 'bg-primary-100 text-primary-800',
                                                        'delivered' => 'bg-green-100 text-green-800',
                                                        'cancelled' => 'bg-red-100 text-red-800',
                                                    ][$order->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <i class="hi-outline hi-calendar h-4 w-4 text-gray-400 mr-1.5"></i>
                                                {{ $order->created_at->format('M d, Y') }}
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <i class="hi-outline hi-cube h-4 w-4 text-gray-400 mr-1.5"></i>
                                                {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0 flex items-center">
                                        <p class="text-sm font-medium text-gray-900">
                                            ₦{{ number_format($order->total_amount, 2) }}
                                        </p>
                                        <i class="hi-outline hi-chevron-right ml-2 h-5 w-5 text-gray-400"></i>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="px-6 py-4 border-t border-gray-200 text-center">
                    <a href="{{ route('orders.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 inline-flex items-center">
                        View all orders
                        <i class="hi-outline hi-arrow-right ml-1 h-4 w-4"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-12 px-6">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-primary-100">
                        <i class="hi-outline hi-shopping-bag h-8 w-8 text-primary-600"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No recent orders</h3>
                    <p class="mt-1 text-sm text-gray-500">Your recent orders will appear here.</p>
                    <div class="mt-6">
                        <a href="{{ route('shop') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="hi-outline hi-shopping-cart -ml-1 mr-2 h-5 w-5"></i>
                            Start Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Recently Viewed Panel -->
        <div class="bg-white shadow-lg overflow-hidden rounded-2xl border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <i class="hi-outline hi-eye h-5 w-5 text-primary-600 mr-2"></i>
                        Recently Viewed
                    </h3>
                    <a href="{{ route('shop') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 flex items-center">
                        View All
                        <i class="hi-outline hi-arrow-right ml-1 h-4 w-4"></i>
                    </a>
                </div>
            </div>
            
            @if(isset($recentlyViewed) && $recentlyViewed->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-6">
                    @foreach($recentlyViewed as $product)
                        <a href="{{ route('products.show', $product) }}" class="group flex items-start space-x-4 p-3 rounded-xl border border-gray-200 hover:shadow-md transition-shadow duration-200">
                            <div class="flex-shrink-0 h-20 w-20 rounded-lg bg-gray-100 overflow-hidden">
                                <img class="h-full w-full object-cover" 
                                     src="{{ $product->getFirstMediaUrl('products') ?: asset('images/placeholder-product.png') }}" 
                                     alt="{{ $product->name }}"
                                     loading="lazy">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 group-hover:text-primary-600 truncate">{{ $product->name }}</p>
                                <p class="text-sm text-primary-600 font-semibold mt-1">₦{{ number_format($product->price, 2) }}</p>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <i class="hi-outline hi-star h-4 w-4 text-yellow-400 mr-1"></i>
                                    <span>4.8</span>
                                    <span class="mx-1">•</span>
                                    <span>24 reviews</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 px-6">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-primary-100">
                        <i class="hi-outline hi-eye h-7 w-7 text-primary-600"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No recently viewed products</h3>
                    <p class="mt-1 text-sm text-gray-500">Your recently viewed products will appear here.</p>
                    <div class="mt-6">
                        <a href="{{ route('shop') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="hi-outline hi-shopping-cart -ml-1 mr-2 h-5 w-5"></i>
                            Browse Products
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
