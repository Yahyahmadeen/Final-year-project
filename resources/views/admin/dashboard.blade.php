@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 font-medium">Total Users</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $total_users ?? 0 }}</h3>
            </div>
            <div class="w-14 h-14 bg-primary-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-2xl text-primary-600"></i>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 font-medium">Total Orders</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $total_orders ?? 0 }}</h3>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-shopping-cart text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 font-medium">Total Revenue</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">₦{{ number_format($total_revenue ?? 0, 0) }}</h3>
            </div>
            <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-dollar-sign text-2xl text-purple-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h4 class="text-lg font-semibold text-gray-900">Recent Orders</h4>
                <a href="#" class="text-sm text-primary-600 hover:text-primary-700">View All</a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recent_orders ?? [] as $order)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                        <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900">₦{{ number_format($order->total_amount, 0) }}</p>
                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No recent orders</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h4 class="text-lg font-semibold text-gray-900">Recent Users</h4>
                <a href="#" class="text-sm text-primary-600 hover:text-primary-700">View All</a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recent_users ?? [] as $user)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="inline-block px-3 py-1 text-xs rounded-full bg-secondary-100 text-secondary-800">
                        {{ $user->role }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No recent users</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
