<x-guest-layout>
    <div class="min-h-screen flex">
        @section('title', 'Forgot Password - ' . config('app.name'))
        
        <!-- Left Side - Background Image -->
        <div class="hidden lg:flex lg:w-1/2 relative">
            <div 
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80')"
            >
                <div class="absolute inset-0 bg-gradient-to-br from-primary-600/90 to-secondary-800/90"></div>
            </div>
            <div class="relative z-10 flex flex-col justify-center px-12 text-white">
                <div class="mb-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center space-x-3 mb-8">
                        <div class="bg-white/20 backdrop-blur-sm text-white p-4 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold">{{ config('app.name') }}</h1>
                            <p class="text-white/80">Multi-Vendor Marketplace</p>
                        </div>
                    </a>
                </div>
                <div class="space-y-6">
                    <h2 class="text-4xl font-bold leading-tight">
                        Forgot your password?
                    </h2>
                    <p class="text-xl text-white/90 leading-relaxed">
                        No worries! We'll help you reset your password and get back to shopping in no time.
                    </p>
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">Secure password reset process</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">Instant email delivery</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">24/7 support if you need help</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Forgot Password Form -->
        <div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
            <div class="max-w-md w-full space-y-8">
                <!-- Mobile Header -->
                <div class="text-center lg:hidden">
                    <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 mb-6">
                        <div class="bg-primary-500 text-white p-3 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-secondary-800">{{ config('app.name') }}</h1>
                            <p class="text-sm text-gray-500">Multi-Vendor Marketplace</p>
                        </div>
                    </a>
                </div>
                
                <!-- Header -->
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-secondary-800 mb-2">Reset your password</h2>
                    <p class="text-gray-600">Enter your email to receive a reset link</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form class="mt-8 space-y-6" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="rounded-md shadow-sm space-y-4">
                        <!-- Email -->
                        <div>
                            <label for="email" class="sr-only">Email address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input id="email" name="email" type="email" autocomplete="email" required 
                                    class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                    placeholder="Email address" value="{{ old('email') }}" autofocus>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-primary-500 group-hover:text-primary-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Remember your password? 
                        <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                            {{ __('Sign in') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
