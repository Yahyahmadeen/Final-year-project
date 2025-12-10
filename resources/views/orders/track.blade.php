@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 to-secondary-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-100 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Track Your Order</h1>
            <p class="text-gray-600">Enter your order number to see the current status and tracking information</p>
        </div>

        <!-- Tracking Form -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            <form method="POST" action="{{ route('orders.track.search') }}" class="space-y-6">
                @csrf
                
                <!-- Order Number -->
                <div>
                    <label for="order_number" class="block text-sm font-medium text-gray-700 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                        Order Number
                    </label>
                    <input 
                        type="text" 
                        id="order_number" 
                        name="order_number" 
                        value="{{ old('order_number') }}"
                        placeholder="e.g., ORD-ABC123XYZ"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('order_number') border-red-500 @enderror"
                        required
                    >
                    @error('order_number')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-primary-600 to-primary-700 text-white py-4 px-6 rounded-xl font-semibold text-lg hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transform hover:scale-105 transition-all shadow-lg"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Track My Order
                </button>
            </form>

            <!-- Help Text -->
            <div class="mt-8 p-4 bg-gray-50 rounded-xl">
                <h3 class="text-sm font-medium text-gray-900 mb-2">Need Help?</h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Your order number was sent to your email after placing the order</li>
                    <li>• Order numbers typically start with "ORD-" followed by letters and numbers</li>
                    <li>• Example: ORD-ABC123XYZ or ORD-675A2B1C3D</li>
                    <li>• If you can't find your order number, check your email confirmation</li>
                </ul>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="mt-8 text-center">
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Back to Home
                </a>
                <a href="{{ route('shop') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
