@extends('layouts.vendor')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-secondary-800">Dashboard</h1>
    <p class="text-gray-600 mt-1">Welcome back! Here's what's happening with your store.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Products -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-100 rounded-xl">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-secondary-800">{{ $stats['total_products'] ?? 0 }}</h3>
        <p class="text-sm text-gray-600">Total Products</p>
        <p class="text-xs text-green-600 mt-2">{{ $stats['published_products'] ?? 0 }} published</p>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-green-100 rounded-xl">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-secondary-800">{{ $stats['total_orders'] ?? 0 }}</h3>
        <p class="text-sm text-gray-600">Total Orders</p>
        <p class="text-xs text-yellow-600 mt-2">{{ $stats['pending_orders'] ?? 0 }} pending</p>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-purple-100 rounded-xl">
                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-secondary-800">₦{{ number_format($stats['total_revenue'] ?? 0, 0) }}</h3>
        <p class="text-sm text-gray-600">Total Revenue</p>
        <p class="text-xs text-gray-500 mt-2">From paid orders</p>
    </div>

    <!-- Wallet Balance -->
    <a href="{{ route('vendor.wallet.index') }}" class="bg-gradient-to-br from-emerald-500 via-green-500 to-teal-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl hover:from-emerald-600 hover:via-green-600 hover:to-teal-700 transition-all duration-300 block border-2 border-green-400/30">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-white/25 backdrop-blur-sm rounded-xl shadow-inner">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <svg class="h-5 w-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </div>
        <h3 class="text-3xl font-bold drop-shadow-sm">₦{{ number_format($vendor->wallet_balance ?? 0, 2) }}</h3>
        <p class="text-sm text-white font-medium mt-1">Wallet Balance</p>
        <p class="text-xs text-white/80 mt-2 flex items-center">
            <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
            Click to manage wallet
        </p>
    </a>
</div>

<!-- Recent Orders & Products -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-secondary-800">Recent Orders</h2>
            <a href="{{ route('vendor.orders.index') }}" class="text-primary-500 text-sm hover:text-primary-600 font-medium">View All →</a>
        </div>

        @if(count($recentOrders) > 0)
        <div class="space-y-4">
            @foreach($recentProducts as $order)
            <a href="{{ route('vendor.orders.show', $order->id) }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-1">
                        <span class="font-semibold text-secondary-800">{{ $order->order_number }}</span>
                        <span class="px-2 py-1 rounded text-xs font-medium {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600">{{ $order->customer->name ?? 'Guest' }}</p>
                    <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-secondary-800">₦{{ number_format($order->total, 0) }}</p>
                    <span class="text-xs px-2 py-1 rounded {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <svg class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <p class="text-gray-600">No orders yet</p>
        </div>
        @endif
    </div>

    <!-- Recent Products -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-secondary-800">Recent Products</h2>
            <a href="{{ route('vendor.products.index') }}" class="text-primary-500 text-sm hover:text-primary-600 font-medium">View All →</a>
        </div>

        @if(count($recentProducts) > 0)
        <div class="space-y-4">
            @foreach($recentProducts as $product)
            <a href="{{ route('vendor.products.edit', $product->id) }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                <div class="flex items-center space-x-4 flex-1">
                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-secondary-800">{{ $product->name }}</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-sm text-gray-600">₦{{ number_format($product->price, 0) }}</span>
                            <span class="text-xs text-gray-500">• Stock: {{ $product->stock }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $product->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="flex items-center justify-end space-x-1 text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product->average_rating))
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @else
                                <svg class="h-4 w-4 fill-current text-gray-300" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endif
                        @endfor
                        <span class="text-xs text-gray-500 ml-1">({{ $product->reviews_count }})</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <svg class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <p class="text-gray-600">No products yet</p>
            <a href="{{ route('vendor.products.create') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Add Your First Product
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Recent Reviews -->
<div class="mt-8 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-secondary-800">Recent Reviews</h2>
        <a href="{{ route('vendor.reviews') }}" class="text-primary-500 text-sm hover:text-primary-600 font-medium">View All →</a>
    </div>

    @if(count($recentReviews) > 0)
    <div class="space-y-6">
        @foreach($recentReviews as $review)
        <div class="border-b border-gray-100 pb-6 last:border-0 last:pb-0 last:mb-0">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-600 font-medium">{{ substr($review->user->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $review->user->name }}</p>
                        <div class="flex items-center">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @else
                                        <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('vendor.products.edit', $review->product_id) }}" class="text-sm text-primary-500 hover:text-primary-600">View Product</a>
            </div>
            <div class="mt-2 pl-13">
                <p class="text-gray-700">{{ $review->comment }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12">
        <svg class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
        <p class="text-gray-600">No reviews yet</p>
    </div>
    @endif
</div>
@endsection