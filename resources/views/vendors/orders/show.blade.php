@extends('layouts.vendor')

@section('title', 'Order Details')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-secondary-800">Order #{{ $order->order_number }}</h1>
            <p class="text-gray-600 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t H:i') }}</p>
        </div>
        <a href="{{ route('vendor.orders.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
            ← Back to Orders
        </a>
    </div>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Status Update -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-secondary-800 mb-4">Update Order Status</h2>
            <form action="{{ route('vendor.orders.update-status', $order->id) }}" method="POST" class="flex gap-4">
                @csrf
                @method('PUT')
                <select name="status" class="flex-1 px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500" required>
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="px-6 py-2 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition-colors">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-secondary-800 mb-6">Your Products in this Order</h2>
            <div class="space-y-4">
                @foreach($vendorItems as $item)
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                        @if($item->product && $item->product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->product->images->first()->path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-secondary-800">{{ $item->product->name ?? 'Product Deleted' }}</h3>
                        <p class="text-sm text-gray-600 mt-1">SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                        <div class="flex items-center gap-4 mt-2">
                            <span class="text-sm text-gray-600">Qty: {{ $item->quantity }}</span>
                            <span class="text-sm text-gray-600">Price: ₦{{ number_format($item->price, 0) }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-secondary-800">₦{{ number_format($item->price * $item->quantity, 0) }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Vendor Subtotal -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-secondary-800">Your Subtotal</span>
                    <span class="text-2xl font-bold text-primary-600">₦{{ number_format($vendorItems->sum(function($item) { return $item->price * $item->quantity; }), 0) }}</span>
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-secondary-800 mb-4">Shipping Address</h2>
            @if($order->address)
            <div class="space-y-2 text-gray-700">
                <p class="font-medium">{{ $order->address->full_name }}</p>
                <p>{{ $order->address->address_line1 }}</p>
                @if($order->address->address_line2)
                <p>{{ $order->address->address_line2 }}</p>
                @endif
                <p>{{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->postal_code }}</p>
                <p>{{ $order->address->country }}</p>
                <p class="pt-2 border-t border-gray-200 mt-2">Phone: {{ $order->address->phone }}</p>
            </div>
            @else
            <p class="text-gray-500">No shipping address provided</p>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Order Summary -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-secondary-800 mb-4">Order Summary</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Number</span>
                    <span class="font-semibold text-secondary-800">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Date</span>
                    <span class="font-medium text-secondary-800">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Amount</span>
                    <span class="font-bold text-secondary-800">₦{{ number_format($order->total_amount, 0) }}</span>
                </div>
                <div class="pt-3 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Payment Status</span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : ($order->payment_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Order Status</span>
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : ($order->status == 'shipped' ? 'bg-purple-100 text-purple-800' : ($order->status == 'processing' ? 'bg-blue-100 text-blue-800' : ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'))) }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Payment Method</span>
                    <span class="font-medium text-secondary-800">{{ ucfirst($order->payment_method) }}</span>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-secondary-800 mb-4">Customer Information</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Name</p>
                    <p class="font-medium text-secondary-800">{{ $order->user->name ?? 'Guest' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium text-secondary-800">{{ $order->user->email ?? 'N/A' }}</p>
                </div>
                @if($order->user && $order->user->phone)
                <div>
                    <p class="text-sm text-gray-600">Phone</p>
                    <p class="font-medium text-secondary-800">{{ $order->user->phone }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Order Notes -->
        @if($order->notes)
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-secondary-800 mb-4">Order Notes</h2>
            <p class="text-gray-700">{{ $order->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
