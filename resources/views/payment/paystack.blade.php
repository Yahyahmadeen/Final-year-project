@extends('layouts.app')

@push('styles')
<style>
    .btn-pay {
        background: linear-gradient(to right, #10B981, #059669);
        transition: all 0.3s ease;
    }
    .btn-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
    }
    .btn-pay:active {
        transform: translateY(0);
    }
    .order-summary {
        background-color: #F9FAFB;
        border-radius: 0.75rem;
    }
</style>
@endpush

@push('scripts')
    <!-- Paystack Inline Script -->
    <script src="https://js.paystack.co/v1/inline.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payButton = document.getElementById('pay-button');
            const paymentMethods = document.querySelectorAll('.payment-method');
            
            // Select first payment method by default
            if (paymentMethods.length > 0) {
                paymentMethods[0].classList.add('active');
            }
            
            // Toggle payment method selection
            paymentMethods.forEach(method => {
                method.addEventListener('click', function() {
                    paymentMethods.forEach(m => m.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            if (payButton) {
                payButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Show loading state
                    const originalText = payButton.innerHTML;
                    payButton.disabled = true;
                    payButton.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    `;
                    
                    if (!window.PaystackPop) {
                        alert('Paystack is not loaded. Please refresh and try again.');
                        payButton.disabled = false;
                        payButton.innerHTML = originalText;
                        return;
                    }

                    const handler = window.PaystackPop.setup({
                        key: '{{ $paystackPublicKey }}',
                        email: '{{ $user->email }}',
                        amount: {{ round($order->total_amount * 100) }}, // Convert to kobo
                        currency: 'NGN',
                        ref: '{{ $order->order_number }}_' + Date.now(),
                        metadata: {
                            order_id: '{{ $order->id }}',
                            order_number: '{{ $order->order_number }}',
                            customer_name: '{{ $user->name }}',
                        },
                        callback: function(response) {
                            // Payment successful
                            window.location.href = '{{ route("payment.paystack.callback", $order->id) }}?reference=' + response.reference;
                        },
                        onClose: function() {
                            // Reset button state if payment is cancelled
                            payButton.disabled = false;
                            payButton.innerHTML = 'Pay ₦{{ number_format($order->total_amount, 2) }}';
                        }
                    });

                    handler.openIframe();
                });
            }
        });
    </script>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('orders.show', $order->id) }}" 
                       class="text-gray-600 hover:text-primary-600 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Order
                    </a>
                </div>
                <div class="flex items-center">
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        alt="{{ config('app.name') }}" 
                        class="h-8 w-auto"
                    />
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Payment Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <!-- Header -->
                <div class="bg-primary-600 p-8 text-white text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-center mb-2">Secure Payment</h2>
                    <p class="text-primary-100">
                        Complete your payment with Paystack
                    </p>
                </div>

                <!-- Order Summary -->
                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->order_number }}</h3>
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        
                        <div class="order-summary p-6 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Order Number</span>
                                <span class="font-medium text-gray-900">#{{ $order->order_number }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Items</span>
                                <span class="font-medium text-gray-900">
                                    {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium text-gray-900">₦{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium text-gray-900">₦{{ number_format($order->shipping_amount, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium text-gray-900">₦{{ number_format($order->tax_amount, 2) }}</span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total</span>
                                    <span class="text-2xl font-bold text-green-600">₦{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <button
                        id="pay-button"
                        class="w-full btn-pay text-white py-4 px-6 rounded-2xl font-bold text-lg focus:outline-none focus:ring-4 focus:ring-green-200 transition-all duration-300 flex items-center justify-center space-x-3"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span>Pay ₦{{ number_format($order->total_amount, 2) }} with Paystack</span>
                    </button>

                    <!-- Security Notice -->
                    <div class="mt-6 flex items-center justify-center space-x-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Your payment is secured by Paystack SSL encryption</span>
                    </div>

                    <!-- Support -->
                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-500">
                            Need help? 
                            <a href="#" class="text-primary-600 hover:underline font-medium">Contact Support</a>
                        </p>
                        <div class="mt-4 flex items-center justify-center space-x-4">
                            <span class="text-xs text-gray-400"> {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Order -->
            <div class="mt-6 text-center">
                <a href="{{ route('orders.show', $order->id) }}" 
                   class="inline-flex items-center space-x-2 text-gray-600 hover:text-primary-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back to Order Details</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
