@extends('layouts.app')

@push('styles')
<style>
    .tracking-step-completed {
        @apply bg-green-100 border-green-200 text-green-800;
    }
    .tracking-step-current {
        @apply bg-blue-100 border-blue-200 text-blue-800;
    }
    .tracking-step-pending {
        @apply bg-gray-100 border-gray-200 text-gray-500;
    }
    .tracking-step-cancelled {
        @apply bg-red-100 border-red-200 text-red-800;
    }
    .tracking-line-completed {
        @apply bg-green-500;
    }
    .tracking-line-pending {
        @apply bg-gray-300;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 to-secondary-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Tracking</h1>
            <p class="text-gray-600">Track the progress of your order</p>
        </div>

        <!-- Order Summary Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Order #{{ $order->order_number }}</h2>
                    <p class="text-gray-600">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <div class="inline-flex items-center px-4 py-2 rounded-xl border-2 
                        @if($order->status === 'delivered') bg-green-100 border-green-200 text-green-800
                        @elseif($order->status === 'shipped') bg-blue-100 border-blue-200 text-blue-800
                        @elseif($order->status === 'processing') bg-yellow-100 border-yellow-200 text-yellow-800
                        @elseif($order->status === 'cancelled') bg-red-100 border-red-200 text-red-800
                        @else bg-gray-100 border-gray-200 text-gray-800
                        @endif">
                        <span class="font-semibold capitalize">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Customer</p>
                    <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                    <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Amount</p>
                    <p class="font-bold text-xl text-primary-600">₦{{ number_format($order->total_amount, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Payment Status</p>
                    <div class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium
                        @if($order->payment_status === 'paid') bg-green-100 text-green-800
                        @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracking Timeline -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Order Progress</h3>
            
            <div class="relative">
                @foreach($trackingSteps as $index => $step)
                    <div class="flex items-start mb-8 last:mb-0">
                        <!-- Step Icon -->
                        <div class="flex-shrink-0 relative">
                            <div class="w-12 h-12 rounded-full border-2 flex items-center justify-center
                                @if(isset($step['is_cancelled'])) tracking-step-cancelled
                                @elseif($step['completed']) tracking-step-completed
                                @elseif($loop->first && !$step['completed']) tracking-step-current
                                @else tracking-step-pending
                                @endif">
                                @if($step['icon'] === 'shopping-cart')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                @elseif($step['icon'] === 'credit-card')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                @elseif($step['icon'] === 'truck')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif($step['icon'] === 'check-circle')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif($step['icon'] === 'x-circle')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            
                            <!-- Connecting Line -->
                            @if(!$loop->last)
                                <div class="absolute top-12 left-1/2 transform -translate-x-1/2 w-0.5 h-16 
                                    @if($step['completed'] && !isset($step['is_cancelled'])) tracking-line-completed
                                    @else tracking-line-pending
                                    @endif">
                                </div>
                            @endif
                        </div>

                        <!-- Step Content -->
                        <div class="ml-4 flex-1">
                            <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $step['title'] }}</h4>
                            <p class="text-gray-600 mb-2">{{ $step['description'] }}</p>
                            @if($step['date'])
                                <p class="text-sm text-gray-500">
                                    {{ $step['date']->format('F j, Y \a\t g:i A') }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Order Items</h3>
            
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                            @if($item->product && $item->product->imagesFirst && count($item->product->imagesFirst) > 0)
                                <img src="{{ asset('storage/' . $item->product->imagesFirst[0]['path']) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 mb-1">
                                {{ $item->product_name ?? ($item->product->name ?? 'Product') }}
                            </h4>
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span>Qty: {{ $item->quantity }}</span>
                                <span>Price: ₦{{ number_format($item->product_price, 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <p class="text-lg font-semibold text-gray-900">
                                ₦{{ number_format($item->total_price, 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Shipping Address -->
        @if($order->shipping_address)
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Shipping Address</h3>
                <div class="text-gray-600">
                    @if(is_array($order->shipping_address))
                        <p>{{ $order->shipping_address['name'] ?? '' }}</p>
                        <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                        <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }}</p>
                        <p>{{ $order->shipping_address['phone'] ?? '' }}</p>
                    @else
                        <p>{{ $order->shipping_address }}</p>
                    @endif
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('orders.track') }}" class="inline-flex items-center justify-center px-6 py-3 border border-primary-300 text-primary-700 bg-white rounded-xl font-medium hover:bg-primary-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Track Another Order
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 text-white rounded-xl font-medium hover:bg-primary-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
