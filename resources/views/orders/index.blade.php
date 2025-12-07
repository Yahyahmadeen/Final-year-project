@extends('layouts.app')

@push('styles')
    <style>
        .order-status-pending {
            @apply bg-yellow-100 text-yellow-800 border-yellow-200;
        }
        .order-status-processing {
            @apply bg-blue-100 text-blue-800 border-blue-200;
        }
        .order-status-shipped {
            @apply bg-indigo-100 text-indigo-800 border-indigo-200;
        }
        .order-status-delivered {
            @apply bg-green-100 text-green-800 border-green-200;
        }
        .order-status-cancelled {
            @apply bg-red-100 text-red-800 border-red-200;
        }
        .payment-status-pending {
            @apply bg-yellow-100 text-yellow-800 border-yellow-200;
        }
        .payment-status-paid {
            @apply bg-green-100 text-green-800 border-green-200;
        }
        .payment-status-failed {
            @apply bg-red-100 text-red-800 border-red-200;
        }
        .payment-status-refunded {
            @apply bg-gray-100 text-gray-800 border-gray-200;
        }
        .payment-status-cooperative_pending {
            @apply bg-orange-100 text-orange-800 border-orange-200;
        }
        .payment-status-cooperative_approved {
            @apply bg-green-100 text-green-800 border-green-200;
        }
        .payment-status-cooperative_rejected {
            @apply bg-red-100 text-red-800 border-red-200;
        }
    </style>
@endpush

@section('content')
<div class="py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if($orders->isNotEmpty())
            <div class="space-y-6">
                @foreach($orders as $order)
                    @php
                        $statusClass = 'order-status-' . strtolower($order->status);
                        $paymentStatusClass = 'payment-status-' . strtolower($order->payment_status);
                        $paymentStatusText = [
                            'pending' => 'Payment Pending',
                            'paid' => 'Paid',
                            'failed' => 'Payment Failed',
                            'refunded' => 'Refunded',
                            'cooperative_pending' => 'Coop Pending',
                            'cooperative_approved' => 'Coop Approved',
                            'cooperative_rejected' => 'Coop Rejected'
                        ][strtolower($order->payment_status)] ?? 'Unknown';
                    @endphp

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Order Header -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-secondary-800">
                                            Order #{{ $order->order_number ?? $order->id }}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            Placed on {{ $order->created_at->format('F j, Y') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                                    <!-- Order Status -->
                                    <div class="flex items-center space-x-2 px-3 py-2 rounded-xl border {{ $statusClass }}">
                                        <span class="text-sm font-medium capitalize">
                                            {{ $order->status ? ucfirst($order->status) : 'Pending' }}
                                        </span>
                                    </div>
                                    
                                    <!-- Payment Status -->
                                    <div class="flex items-center space-x-2 px-3 py-2 rounded-xl border {{ $paymentStatusClass }}">
                                        <span class="text-sm font-medium">
                                            {{ $paymentStatusText }}
                                        </span>
                                    </div>
                                    
                                    <a 
                                        href="{{ route('orders.show', $order->id) }}" 
                                        class="inline-flex items-center space-x-2 text-primary-600 hover:text-primary-700 transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span class="text-sm font-medium">View Details</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Items</p>
                                    <p class="text-lg font-semibold text-secondary-800">
                                        {{ $order->items_count ?? $order->items->count() }} {{ Str::plural('item', $order->items_count ?? $order->items->count()) }}
                                    </p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Total Amount</p>
                                    <p class="text-lg font-semibold text-secondary-800">
                                        ₦{{ number_format($order->total_amount, 2) }}
                                    </p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Payment Method</p>
                                    <p class="text-lg font-semibold text-secondary-800 capitalize">
                                        {{ $order->payment_method ?? 'Not specified' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Order Items Preview -->
                            @if($order->items && $order->items->count() > 0)
                                <div class="mt-6 pt-6 border-t border-gray-100">
                                    <h4 class="text-sm font-medium text-gray-700 mb-4">Order Items</h4>
                                    <div class="space-y-3">
                                        @foreach($order->items->take(3) as $item)
                                            <div class="flex items-center space-x-4">
                                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-medium text-secondary-800">
                                                        {{ $item->product->name ?? 'Product' }}
                                                    </p>
                                                    <p class="text-sm text-gray-600">
                                                        Qty: {{ $item->quantity }} × ₦{{ number_format($item->price, 2) }}
                                                    </p>
                                                </div>
                                                <p class="font-semibold text-secondary-800">
                                                    ₦{{ number_format($item->total, 2) }}
                                                </p>
                                            </div>
                                        @endforeach
                                        
                                        @if($order->items->count() > 3)
                                            <p class="text-sm text-gray-600 text-center py-2">
                                                +{{ $order->items->count() - 3 }} more {{ Str::plural('item', $order->items->count() - 3) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="flex justify-center mt-8">
                        <nav class="flex items-center space-x-2">
                            @if($orders->onFirstPage())
                                <span class="px-4 py-2 rounded-lg bg-gray-100 text-gray-400 text-sm font-medium cursor-not-allowed">
                                    &laquo; Previous
                                </span>
                            @else
                                <a href="{{ $orders->previousPageUrl() }}" class="px-4 py-2 rounded-lg bg-white text-gray-700 hover:bg-gray-50 border border-gray-300 text-sm font-medium transition-colors">
                                    &laquo; Previous
                                </a>
                            @endif

                            @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                @if($page == $orders->currentPage())
                                    <span class="px-4 py-2 rounded-lg bg-primary-500 text-white text-sm font-medium">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="px-4 py-2 rounded-lg bg-white text-gray-700 hover:bg-gray-50 border border-gray-300 text-sm font-medium transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if($orders->hasMorePages())
                                <a href="{{ $orders->nextPageUrl() }}" class="px-4 py-2 rounded-lg bg-white text-gray-700 hover:bg-gray-50 border border-gray-300 text-sm font-medium transition-colors">
                                    Next &raquo;
                                </a>
                            @else
                                <span class="px-4 py-2 rounded-lg bg-gray-100 text-gray-400 text-sm font-medium cursor-not-allowed">
                                    Next &raquo;
                                </span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-16">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 max-w-md mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-300 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h2 class="text-2xl font-bold text-secondary-800 mb-4">No orders yet</h2>
                    <p class="text-gray-600 mb-8">
                        You haven't placed any orders yet. Start shopping to see your orders here.
                    </p>
                    <a 
                        href="{{ route('shop') }}" 
                        class="inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-6 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>Start Shopping</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
