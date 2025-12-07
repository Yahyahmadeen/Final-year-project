@extends('layouts.app')

@section('title', 'Checkout - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-primary-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 flex items-center justify-center">
                            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }} Logo" class="w-8 h-8 object-contain">
                        </div>
                        <h1 class="text-xl font-bold text-secondary-800">Checkout</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="payment_method" value="wallet">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Checkout Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Shipping Address -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                    </svg>
                                </div>
                                <h2 class="text-lg font-semibold text-secondary-800">Shipping Address</h2>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Full Name
                                    </label>
                                    <input
                                        type="text"
                                        name="shipping_address[name]"
                                        value="{{ old('shipping_address.name', auth()->user()->name ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        required
                                    />
                                    @error('shipping_address.name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Phone Number
                                    </label>
                                    <input
                                        type="tel"
                                        name="shipping_address[phone]"
                                        value="{{ old('shipping_address.phone') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        required
                                    />
                                    @error('shipping_address.phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Street Address
                                    </label>
                                    <textarea
                                        name="shipping_address[address]"
                                        rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        required
                                    >{{ old('shipping_address.address') }}</textarea>
                                    @error('shipping_address.address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        City
                                    </label>
                                    <input
                                        type="text"
                                        name="shipping_address[city]"
                                        value="{{ old('shipping_address.city') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        required
                                    />
                                    @error('shipping_address.city')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        State
                                    </label>
                                    <input
                                        type="text"
                                        name="shipping_address[state]"
                                        value="{{ old('shipping_address.state') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        required
                                    />
                                    @error('shipping_address.state')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Postal Code
                                    </label>
                                    <input
                                        type="text"
                                        name="shipping_address[postal_code]"
                                        value="{{ old('shipping_address.postal_code') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    />
                                    @error('shipping_address.postal_code')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Wallet Balance -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-sm border border-blue-100 p-6 mb-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-800">Wallet Balance</h2>
                                        <p class="text-2xl font-bold text-gray-900">₦{{ number_format($walletBalance, 2) }}</p>
                                    </div>
                                </div>
                                
                                @if($walletBalance < $summary['total'])
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg w-full md:w-auto">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">
                                                    You need <span class="font-semibold">₦{{ number_format($summary['total'] - $walletBalance, 2) }}</span> more to complete this purchase.
                                                </p>
                                                <div class="mt-2">
                                                    <a href="{{ route('wallet.fund.show', ['redirect' => urlencode(route('checkout.index'))]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                    Add Funds to Wallet
                                                </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg w-full md:w-auto">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-green-700">
                                                    Your wallet has sufficient funds for this purchase.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            @if($walletBalance < $summary['total'])
                                <div class="mt-4 text-center text-sm text-gray-600">
                                    <p>After adding funds, you'll be redirected back to complete your purchase.</p>
                                    <a href="{{ route('wallet.fund.show', ['redirect' => urlencode(route('checkout.index'))]) }}" class="mt-2 inline-flex items-center font-medium text-blue-600 hover:text-blue-800 focus:outline-none">
                                        Click here to add funds to your wallet
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <h2 class="text-lg font-semibold text-secondary-800">Payment Method</h2>
                            </div>

                            <div class="space-y-4">
                                <div class="p-4 border-2 border-primary-500 bg-primary-50 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <h3 class="font-medium text-gray-900">Wallet Payment</h3>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Selected
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-500">Pay using your wallet balance</p>
                                            @if($walletBalance < $summary['total'])
                                                <div class="mt-2 text-sm text-red-600">
                                                    Insufficient balance. You need ₦{{ number_format($summary['total'] - $walletBalance, 2) }} more.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-secondary-800 mb-4">Order Notes (Optional)</h3>
                            <textarea
                                name="notes"
                                placeholder="Any special instructions for your order..."
                                rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            >{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="space-y-6">
                        <!-- Cart Items -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-secondary-800 mb-4">Order Summary</h3>
                            
                            <div class="space-y-4 mb-6">
                                @forelse($cartItems as $item)
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                            @if($item->product->images && count($item->product->images) > 0)
                                                <img src="{{ asset('storage/' . $item->product->images[0]) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium text-secondary-800 text-sm">
                                                {{ $item->product->name }}
                                            </p>
                                            <p class="text-xs text-gray-600">
                                                Qty: {{ $item->quantity }} × ₦{{ number_format($item->product->sale_price ?? $item->product->price) }}
                                            </p>
                                        </div>
                                        <p class="font-semibold text-secondary-800">
                                            ₦{{ number_format($item->quantity * ($item->product->sale_price ?? $item->product->price)) }}
                                        </p>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500 py-4">Your cart is empty</p>
                                @endforelse
                            </div>

                            <!-- Price Breakdown -->
                            <div class="border-t border-gray-200 pt-4 space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-secondary-800">₦{{ number_format($summary['subtotal']) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="text-secondary-800">₦{{ number_format($summary['shipping']) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tax (7.5%)</span>
                                    <span class="text-secondary-800">₦{{ number_format($summary['tax']) }}</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold border-t border-gray-200 pt-3">
                                    <span class="text-secondary-800">Total</span>
                                    <span class="text-primary-600">₦{{ number_format($summary['total']) }}</span>
                                </div>
                            </div>

                            <!-- Place Order Button -->
                            <button 
                                type="submit" 
                                id="place-order-btn"
                                class="w-full mt-6 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-xl transition duration-200 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ $walletBalance < $summary['total'] ? 'disabled' : '' }}
                            >
                                <span id="button-text">Place Order - ₦{{ number_format($summary['total'], 2) }}</span>
                                <svg id="button-spinner" class="hidden ml-2 -mr-1 h-5 w-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Security Notice -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Your payment information is secure and encrypted</span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .toast {
        position: fixed;
        top: 1.5rem;
        right: 1.5rem;
        z-index: 9999;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        color: white;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transform: translateX(120%);
        transition: transform 0.3s ease-in-out;
    }
    .toast.show {
        transform: translateX(0);
    }
    .toast.success {
        background-color: #10B981;
    }
    .toast.error {
        background-color: #EF4444;
    }
    .toast .icon {
        margin-right: 0.75rem;
        font-size: 1.25rem;
    }
    .toast .message {
        flex: 1;
    }
    .toast .close {
        margin-left: 1rem;
        cursor: pointer;
        font-size: 1.25rem;
        line-height: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    // Show toast notification
    function showToast(type, message) {
        // Remove any existing toasts
        const existingToast = document.querySelector('.toast');
        if (existingToast) {
            existingToast.remove();
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        // Set toast content
        toast.innerHTML = `
            <div class="icon">
                ${type === 'success' ? '✓' : '✗'}
            </div>
            <div class="message">${message}</div>
            <div class="close">&times;</div>
        `;

        // Add to body
        document.body.appendChild(toast);

        // Show toast
        setTimeout(() => toast.classList.add('show'), 10);

        // Auto-remove after 5 seconds
        const timer = setTimeout(() => {
            toast.remove();
        }, 5000);

        // Close on click
        const closeBtn = toast.querySelector('.close');
        closeBtn.addEventListener('click', () => {
            clearTimeout(timer);
            toast.remove();
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkout-form');
        const placeOrderBtn = document.getElementById('place-order-btn');
        const buttonText = document.getElementById('button-text');
        const buttonSpinner = document.getElementById('button-spinner');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Prevent double submission
            if (placeOrderBtn.disabled) {
                return false;
            }
            
            // Show loading state
            placeOrderBtn.disabled = true;
            buttonText.textContent = 'Processing...';
            if (buttonSpinner) buttonSpinner.classList.remove('hidden');
            
            // Create FormData object
            const formData = new FormData(form);
            
            // Submit form via AJAX
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.redirect) {
                    // For wallet payments, redirect to success page
                    window.location.href = data.redirect;
                } else if (data.success) {
                    // Show success message and redirect
                    showToast('success', data.message || 'Order placed successfully!');
                    setTimeout(() => {
                        window.location.href = data.redirect || '{{ route("orders.index") }}';
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                let errorMessage = 'An error occurred while processing your order. Please try again.';
                
                // Extract error message from response
                if (error.error) {
                    errorMessage = error.error;
                } else if (error.message) {
                    errorMessage = error.message;
                } else if (error.errors) {
                    // Handle validation errors
                    const firstError = Object.values(error.errors)[0];
                    errorMessage = Array.isArray(firstError) ? firstError[0] : firstError;
                }
                
                showToast('error', errorMessage);
                
                // Re-enable button
                placeOrderBtn.disabled = false;
                buttonText.textContent = 'Place Order - ₦{{ number_format($summary['total'], 2) }}';
                if (buttonSpinner) buttonSpinner.classList.add('hidden');
            });
        });
        
        // Handle insufficient balance
        @if($walletBalance < $summary['total'])
            const addFundsBtn = document.querySelector('a[href*="wallet/fund"]');
            if (addFundsBtn) {
                addFundsBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Store the current URL to return after adding funds
                    localStorage.setItem('returnToCheckout', window.location.href);
                    window.location.href = this.href;
                });
            }
        @endif
        
        // Check if we're returning from adding funds
        if (localStorage.getItem('returnToCheckout')) {
            const returnUrl = localStorage.getItem('returnToCheckout');
            localStorage.removeItem('returnToCheckout');
            
            // Show a success message if funds were added
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('funded') === 'true') {
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'bg-green-50 border-l-4 border-green-400 p-4 mb-6';
                alertDiv.innerHTML = `
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                Your wallet has been funded successfully! You can now complete your order.
                            </p>
                        </div>
                    </div>
                `;
                form.prepend(alertDiv);
                
                // Remove the query parameter without refreshing
                const newUrl = window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            }
        }
    });
</script>
@endpush
@endsection
