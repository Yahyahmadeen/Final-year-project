@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M19.707 9.293l-2-2L11 14.586V2h-2v12.586l-6.707-6.707-1.414 1.414L10 18.414l9.121-9.121-1.414-1.414z"/>
                        </svg>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Shopping Cart</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Cart <span class="text-gray-500 text-xl">({{ $cartItems->count() }} items)</span></h1>
            <a href="{{ route('shop') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">
                ← Continue Shopping
            </a>
        </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Cart Items -->
        <div class="lg:w-2/3">
            @if($cartItems->count() > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
                    <!-- Cart Header -->
                    <div class="hidden md:grid grid-cols-12 bg-gray-50 border-b border-gray-200 p-4">
                        <div class="col-span-6">
                            <span class="text-sm font-medium text-gray-500">Product</span>
                        </div>
                        <div class="col-span-2 text-center">
                            <span class="text-sm font-medium text-gray-500">Price</span>
                        </div>
                        <div class="col-span-2 text-center">
                            <span class="text-sm font-medium text-gray-500">Quantity</span>
                        </div>
                        <div class="col-span-2 text-right">
                            <span class="text-sm font-medium text-gray-500">Total</span>
                        </div>
                    </div>
                    
                    <!-- Cart Items -->
                    <div class="divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                            <div class="p-4 flex flex-col md:grid md:grid-cols-12 gap-4">
                                <!-- Product Image & Info -->
                                <div class="flex items-center space-x-4 col-span-6">
                                    <div class="flex-shrink-0 h-20 w-20 rounded-md overflow-hidden bg-gray-100">
                                        @php
                                            $images = is_array($item->product->images) ? $item->product->images : [];
                                            $firstImage = !empty($images) ? $images[0] : null;
                                        @endphp
                                        @if(!empty($firstImage))
                                            <img src="{{ asset('storage/' . $firstImage) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-gray-200">
                                                <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-base font-medium text-gray-900">
                                            <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-primary-600">
                                                {{ $item->product->name }}
                                            </a>
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $item->product->category->name }}
                                        </p>
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="flex items-center justify-center col-span-2">
                                    <p class="text-base font-medium text-gray-900">
                                        ₦{{ number_format($item->product->getCurrentPrice(), 2) }}
                                    </p>
                                </div>

                                <!-- Quantity -->
                                <div class="flex items-center justify-center col-span-2">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center border border-gray-300 rounded-md">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" 
                                                onclick="updateQuantity({{ $item->id }}, -1)"
                                                class="px-3 py-1 text-gray-600 hover:bg-gray-50 focus:outline-none">
                                            −
                                        </button>
                                        
                                        <input type="number" 
                                               name="quantity" 
                                               id="quantity-{{ $item->id }}" 
                                               value="{{ $item->quantity }}" 
                                               min="1" 
                                               max="10" 
                                               onchange="this.form.submit()"
                                               class="w-12 text-center border-x border-gray-300 py-1 focus:outline-none focus:ring-1 focus:ring-primary-500">
                                        
                                        <button type="button" 
                                                onclick="updateQuantity({{ $item->id }}, 1)"
                                                class="px-3 py-1 text-gray-600 hover:bg-gray-50 focus:outline-none">
                                            +
                                        </button>
                                    </form>
                                </div>

                                <!-- Total -->
                                <div class="flex items-center justify-end col-span-2">
                                    <p class="text-base font-bold text-gray-900">
                                        ₦{{ number_format($item->product->getCurrentPrice() * $item->quantity, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Mobile Continue Shopping -->
                <div class="mt-6 md:hidden">
                    <a href="{{ route('shop') }}" class="flex items-center text-primary-600 hover:text-primary-800 text-sm font-medium">
                        ← Continue Shopping
                    </a>
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-lg shadow border border-gray-200">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Your cart is empty</h3>
                    <p class="mt-1 text-gray-500">Start shopping to add items to your cart.</p>
                    <div class="mt-6">
                        <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Order Summary -->
        @if($cartItems->count() > 0)
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">Order Summary</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                                <span class="font-medium">₦{{ number_format($summary['subtotal'], 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax (7.5%)</span>
                                <span class="font-medium">₦{{ number_format($summary['tax'], 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium">{{ $summary['shipping'] > 0 ? '₦' . number_format($summary['shipping'], 2) : 'Free' }}</span>
                            </div>
                            @if($summary['shipping'] > 0 && $summary['subtotal'] > 0)
                                <div class="text-sm text-green-600 text-center py-2 bg-green-50 rounded-md">
                                    Add ₦{{ number_format(50000 - $summary['subtotal'], 2) }} more for free shipping
                                </div>
                            @endif
                            <div class="border-t border-gray-200 pt-4 mt-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold">Total</span>
                                    <span class="text-xl font-bold text-gray-900">₦{{ number_format($summary['subtotal'] + $summary['tax'] + $summary['shipping'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('checkout.index') }}" class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                                Proceed to Checkout
                            </a>
                        </div>
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-500">
                                or
                                <a href="{{ route('shop') }}" class="text-primary-600 font-medium hover:text-primary-500">
                                    Continue Shopping
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Secure Payment Info -->
                <div class="mt-6 bg-white rounded-lg shadow-md border border-gray-200 p-6">
                    <div class="flex items-center justify-center space-x-2 text-gray-500">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="text-sm">Secure Checkout</span>
                    </div>
                    <div class="mt-4 flex justify-center space-x-6">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/visa/visa-original.svg" class="h-8" alt="Visa" />
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mastercard/mastercard-original.svg" class="h-8" alt="Mastercard" />
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/paypal/paypal-original.svg" class="h-8" alt="PayPal" />
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@section('scripts')
<script>
    function updateQuantity(itemId, change) {
        const input = document.getElementById(`quantity-${itemId}`);
        let newValue = parseInt(input.value) + change;
        
        // Ensure the value stays within the allowed range (1-10)
        newValue = Math.max(1, Math.min(10, newValue));
        
        // Update the input value
        input.value = newValue;
        
        // Submit the form to update the cart
        input.form.submit();
    }
</script>
@endsection
