@extends('layouts.app')

@push('styles')
    <style>
        .feature-icon {
            @apply bg-primary-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4;
        }
        .feature-icon svg {
            @apply h-8 w-8 text-primary-600;
        }
        .team-member {
            @apply bg-white rounded-2xl shadow-lg p-6 text-center;
        }
        .team-avatar {
            @apply w-24 h-24 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full mx-auto mb-4 flex items-center justify-center;
        }
        .team-avatar svg {
            @apply h-12 w-12 text-white;
        }
    </style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-primary-500 via-primary-600 to-secondary-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6">About eProShop</h1>
                <p class="text-xl text-gray-200 max-w-3xl mx-auto leading-relaxed">
                    Morocco's premier multi-vendor e-commerce platform, 
                    connecting customers with trusted vendors while providing special 
                    benefits for our valued customers.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-white shadow-lg -mt-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-600 mb-2">
                        {{ number_format($stats['total_products'] ?? 0) }}+
                    </div>
                    <div class="text-gray-600">Products</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-600 mb-2">
                        {{ number_format($stats['total_vendors'] ?? 0) }}+
                    </div>
                    <div class="text-gray-600">Vendors</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-600 mb-2">
                        {{ number_format($stats['total_customers'] ?? 0) }}+
                    </div>
                    <div class="text-gray-600">Customers</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-600 mb-2">
                        {{ number_format($stats['total_orders'] ?? 0) }}+
                    </div>
                    <div class="text-gray-600">Orders</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-secondary-800 mb-6">Our Mission</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        To revolutionize e-commerce in Morocco by creating a platform that 
                        empowers local vendors while providing customers with access to 
                        quality products and services.
                    </p>
                    <p class="text-lg text-gray-600 mb-6">
                        We believe in the power of community and aim to bridge 
                        the gap between traditional shopping and modern 
                        e-commerce convenience.
                    </p>
                    <a 
                        href="{{ route('vendors.register') }}" 
                        class="bg-primary-500 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-primary-600 transition-colors inline-block"
                    >
                        Become a Vendor
                    </a>
                </div>
                <div class="bg-gradient-to-br from-primary-100 to-accent-100 rounded-2xl p-8">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-secondary-800">Customer First</h3>
                        </div>
                        <div class="text-center">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-secondary-800">Community</h3>
                        </div>
                        <div class="text-center">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-secondary-800">Trust</h3>
                        </div>
                        <div class="text-center">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-secondary-800">Excellence</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-secondary-800 mb-4">Why Choose eProShop?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    We're more than just an e-commerce platform. We're a community 
                    that supports local businesses and provides the best shopping experience.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-secondary-800 mb-2">
                        Multi-Vendor Marketplace
                    </h3>
                    <p class="text-gray-600">Shop from hundreds of trusted vendors all in one place</p>
                </div>
                
                <div class="text-center">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-secondary-800 mb-2">
                        Secure Payments
                    </h3>
                    <p class="text-gray-600">Safe and secure transactions with our payment integration</p>
                </div>
                
                <div class="text-center">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-secondary-800 mb-2">
                        Quality Assurance
                    </h3>
                    <p class="text-gray-600">We ensure all products meet our quality standards</p>
                </div>
                
                <div class="text-center">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-secondary-800 mb-2">
                        Fast Delivery
                    </h3>
                    <p class="text-gray-600">Quick and reliable delivery across Morocco</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-secondary-800 mb-4">Meet Our Team</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Passionate professionals dedicated to transforming e-commerce in Morocco
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="team-member">
                    <div class="team-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-secondary-800 mb-1">
                        Youssef Alami
                    </h3>
                    <p class="text-primary-600 font-medium mb-3">CEO & Founder</p>
                    <p class="text-gray-600">Passionate about connecting Moroccan businesses with customers</p>
                </div>
                
                <div class="team-member">
                    <div class="team-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-secondary-800 mb-1">
                        Amina Benjelloun
                    </h3>
                    <p class="text-primary-600 font-medium mb-3">CTO</p>
                    <p class="text-gray-600">Leading our technology vision and platform development</p>
                </div>
                
                <div class="team-member">
                    <div class="team-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-secondary-800 mb-1">
                        Karim El Fassi
                    </h3>
                    <p class="text-primary-600 font-medium mb-3">Head of Operations</p>
                    <p class="text-gray-600">Ensuring smooth operations and vendor relationships</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-secondary-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Join the eProShop Community?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Whether you're a customer looking for great products or a vendor 
                wanting to grow your business, we're here for you.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a 
                    href="{{ route('shop') }}" 
                    class="bg-primary-500 text-white px-8 py-4 rounded-2xl font-semibold hover:bg-primary-600 transition-colors"
                >
                    Start Shopping
                </a>
                <a 
                    href="{{ route('vendors.register') }}" 
                    class="border-2 border-accent-500 text-accent-500 px-8 py-4 rounded-2xl font-semibold hover:bg-accent-500 hover:text-secondary-800 transition-colors"
                >
                    Become a Vendor
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
