@extends('layouts.app-layout')

@section('title', 'My Profile - ' . config('app.name'))

@push('styles')
<style>
    .profile-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Profile Header -->
        <div class="profile-card rounded-2xl shadow-xl p-8 mb-8 text-white">
            <div class="flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-8">
                <!-- Profile Avatar -->
                <div class="relative">
                    <div class="w-32 h-32 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-4xl font-bold text-white border-4 border-white/30">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="absolute -bottom-2 -right-2 bg-green-500 w-8 h-8 rounded-full border-4 border-white flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Profile Info -->
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-3xl font-bold mb-2">{{ auth()->user()->name }}</h1>
                    <p class="text-white/80 text-lg mb-1">{{ auth()->user()->email }}</p>
                    <div class="flex flex-wrap gap-2 justify-center md:justify-start mt-4">
                        <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-medium">
                            {{ ucfirst(auth()->user()->role ?? 'Customer') }}
                        </span>
                        @if(auth()->user()->cooperative_id)
                            <span class="px-3 py-1 bg-green-500/80 rounded-full text-sm font-medium">
                                Cooperative Member
                            </span>
                        @endif
                        <span class="px-3 py-1 bg-blue-500/80 rounded-full text-sm font-medium">
                            Member since {{ auth()->user()->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-white/10 rounded-lg p-4">
                        <div class="text-2xl font-bold">{{ auth()->user()->orders()->count() }}</div>
                        <div class="text-sm text-white/80">Orders</div>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4">
                        <div class="text-2xl font-bold">₦{{ number_format(auth()->user()->orders()->sum('total_amount'), 0) }}</div>
                        <div class="text-sm text-white/80">Total Spent</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column - Profile Forms -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Personal Information -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Personal Information
                        </h2>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Security Settings
                        </h2>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white rounded-2xl shadow-lg border border-red-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            Danger Zone
                        </h2>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

            <!-- Right Column - Quick Actions & Stats -->
            <div class="space-y-6">
                
                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('orders.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-100">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">My Orders</div>
                                <div class="text-sm text-gray-500">View order history</div>
                            </div>
                        </a>
                        
                        <a href="{{ route('orders.track') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-100">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">Track Order</div>
                                <div class="text-sm text-gray-500">Track your packages</div>
                            </div>
                        </a>
                        
                        <a href="{{ route('shop') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-100">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">Continue Shopping</div>
                                <div class="text-sm text-gray-500">Browse products</div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Account Stats -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Account Statistics
                    </h3>
                    <div class="space-y-4">
                        <div class="stat-card p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-2xl font-bold text-blue-600">{{ auth()->user()->orders()->count() }}</div>
                                    <div class="text-sm text-blue-600">Total Orders</div>
                                </div>
                                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stat-card p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-2xl font-bold text-green-600">₦{{ number_format(auth()->user()->orders()->sum('total_amount'), 0) }}</div>
                                    <div class="text-sm text-green-600">Total Spent</div>
                                </div>
                                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stat-card p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-2xl font-bold text-purple-600">{{ auth()->user()->created_at->diffForHumans() }}</div>
                                    <div class="text-sm text-purple-600">Member Since</div>
                                </div>
                                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Support -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Need Help?
                    </h3>
                    <p class="text-gray-600 text-sm mb-4">Our support team is here to help you with any questions or issues.</p>
                    <div class="space-y-2">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            hello@eProShop.com
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            +234 800 123 4567
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
