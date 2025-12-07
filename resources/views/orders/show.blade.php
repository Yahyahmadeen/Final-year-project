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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Status -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-secondary-800">Order Status</h3>
                        <div class="flex items-center space-x-2 px-4 py-2 rounded-xl border order-status-{{ strtolower($order->status) }}">
                            <span class="font-medium capitalize">
                                {{ $order->status ? ucfirst($order->status) : 'Pending' }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Order Date</p>
                            <p class="font-medium text-secondary-800">
                                {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Payment Method</p>
                            <p class="font-medium text-secondary-800 capitalize">
                                {{ $order->payment_method ?? 'Not specified' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Payment Status</p>
                            @php
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
                            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-lg text-sm font-medium {{ $paymentStatusClass }}">
                                <span class="capitalize">{{ $paymentStatusText }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Reference -->
                    @if($order->payment_reference)
                        <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-600 mb-1">Payment Reference</p>
                            <p class="font-mono text-sm text-secondary-800">{{ $order->payment_reference }}</p>
                        </div>
                    @endif
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-800 mb-6">Order Items</h3>
                    
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <h4 class="font-medium text-secondary-800 mb-1">
                                        {{ $item->product->name ?? 'Product' }}
                                    </h4>
                                    @if($item->product && $item->product->description)
                                        <p class="text-sm text-gray-600 mb-2">
                                            {{ Str::limit($item->product->description, 100) }}
                                        </p>
                                    @endif
                                    <div class="flex items-center space-x-4 text-sm">
                                        <span class="text-gray-600">Qty: {{ $item->quantity }}</span>
                                        <span class="text-gray-600">Price: ₦{{ number_format($item->price, 2) }}</span>
                                    </div>
                                </div>
                                
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-secondary-800">
                                        ₦{{ number_format($item->total, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Total -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-secondary-800">Total Amount</span>
                            <span class="text-2xl font-bold text-primary-600">
                                ₦{{ number_format($order->total_amount, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary & Shipping -->
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-800 mb-4">Order Summary</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Order Number</p>
                                <p class="font-medium text-secondary-800">
                                    #{{ $order->order_number ?? $order->id }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Items Count</p>
                                <p class="font-medium text-secondary-800">
                                    {{ $order->items_count ?? $order->items->count() }} {{ Str::plural('item', $order->items_count ?? $order->items->count()) }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Total Amount</p>
                                <p class="font-medium text-secondary-800">
                                    ₦{{ number_format($order->total_amount, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                @if($order->shipping_address)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-secondary-800 mb-4">Shipping Address</h3>
                        
                        <div class="space-y-3">
                            @if(isset($order->shipping_address['name']) && $order->shipping_address['name'])
                                <div class="flex items-center space-x-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="text-sm text-gray-700">{{ $order->shipping_address['name'] }}</span>
                                </div>
                            @endif
                            
                            @if(isset($order->shipping_address['phone']) && $order->shipping_address['phone'])
                                <div class="flex items-center space-x-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="text-sm text-gray-700">{{ $order->shipping_address['phone'] }}</span>
                                </div>
                            @endif
                            
                            @if((isset($order->shipping_address['address']) && $order->shipping_address['address']) || 
                                (isset($order->shipping_address['street']) && $order->shipping_address['street']))
                                <div class="flex items-start space-x-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div class="text-sm text-gray-700">
                                        <p>{{ $order->shipping_address['address'] ?? $order->shipping_address['street'] }}</p>
                                        @if(isset($order->shipping_address['city']) && $order->shipping_address['city'])
                                            <p>{{ $order->shipping_address['city'] }}</p>
                                        @endif
                                        @if(isset($order->shipping_address['state']) && $order->shipping_address['state'])
                                            <p>{{ $order->shipping_address['state'] }}</p>
                                        @endif
                                        @if(isset($order->shipping_address['postal_code']) && $order->shipping_address['postal_code'])
                                            <p>{{ $order->shipping_address['postal_code'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Vendor Information -->
                @if($order->vendor)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-secondary-800 mb-4">Vendor</h3>
                        
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-secondary-800">
                                    {{ $order->vendor->store_name ?? $order->vendor->name }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $order->vendor->email }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-800 mb-4">Actions</h3>
                    
                    <div class="space-y-3">
                        <!-- Payment Button - Show for pending Paystack orders -->
                        @if($order->status === 'pending' && $order->payment_method === 'paystack' && $order->payment_status === 'pending')
                            <a href="{{ route('payment.paystack', $order->id) }}" 
                               class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 px-4 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-300 text-center block flex items-center justify-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <span>Pay Now - ₦{{ number_format($order->total_amount, 2) }}</span>
                            </a>
                        @endif

                        <!-- Verify Payment Button - Show for processing orders with pending payment -->
                        @if($order->status === 'processing' && $order->payment_status === 'pending')
                            <form action="{{ route('payment.verify', $order->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-4 rounded-xl font-semibold hover:from-blue-600 hover:to-blue-700 transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Verify Payment Status</span>
                                </button>
                            </form>
                        @endif

                        <!-- Bank Transfer Instructions - Show for pending bank transfer orders -->
                        @if($order->status === 'pending' && $order->payment_method === 'bank_transfer' && $order->payment_status === 'pending')
                            <div class="w-full bg-blue-50 border border-blue-200 rounded-xl p-4">
                                <h4 class="font-semibold text-blue-800 mb-2 flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <span>Bank Transfer Details</span>
                                </h4>
                                <div class="text-sm text-blue-700 space-y-1">
                                    <p><strong>Bank:</strong> Your Bank Name</p>
                                    <p><strong>Account Name:</strong> Your Business Name</p>
                                    <p><strong>Account Number:</strong> 1234567890</p>
                                    <p><strong>Amount:</strong> ₦{{ number_format($order->total_amount, 2) }}</p>
                                    <p><strong>Reference:</strong> {{ $order->order_number ?? $order->id }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Cooperative Status - Show for cooperative orders -->
                        @if($order->payment_method === 'cooperative')
                            <div class="w-full rounded-xl p-4 {{
                                $order->payment_status === 'cooperative_pending' 
                                    ? 'bg-yellow-50 border border-yellow-200' 
                                    : ($order->payment_status === 'cooperative_approved'
                                        ? 'bg-green-50 border border-green-200'
                                        : 'bg-red-50 border border-red-200')
                            }}">
                                <h4 class="font-semibold mb-2 flex items-center space-x-2 {{
                                    $order->payment_status === 'cooperative_pending' 
                                        ? 'text-yellow-800' 
                                        : ($order->payment_status === 'cooperative_approved'
                                            ? 'text-green-800'
                                            : 'text-red-800')
                                }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span>Cooperative Sponsorship</span>
                                </h4>
                                <p class="text-sm {{
                                    $order->payment_status === 'cooperative_pending' 
                                        ? 'text-yellow-700' 
                                        : ($order->payment_status === 'cooperative_approved'
                                            ? 'text-green-700'
                                            : 'text-red-700')
                                }}">
                                    @if($order->payment_status === 'cooperative_pending')
                                        Your cooperative sponsorship request is pending approval.
                                    @elseif($order->payment_status === 'cooperative_approved')
                                        Your cooperative has approved this sponsorship.
                                    @else
                                        Your cooperative sponsorship request was declined.
                                    @endif
                                </p>
                            </div>
                        @endif
                        
                        <a href="{{ route('orders.index') }}" 
                           class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-xl font-medium hover:bg-gray-200 transition-colors text-center block">
                            Back to Orders
                        </a>
                        
                        <a href="{{ route('shop') }}" 
                           class="w-full bg-primary-500 text-white py-3 px-4 rounded-xl font-medium hover:bg-primary-600 transition-colors text-center block">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
