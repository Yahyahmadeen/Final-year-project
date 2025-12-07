<x-guest-layout>
    <div class="min-h-screen flex">
        @section('title', 'Verify Email - ' . config('app.name'))
        
        <!-- Left Side - Background Image -->
        <div class="hidden lg:flex lg:w-1/2 relative">
            <div 
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80')"
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
                        Verify Your Email
                    </h2>
                    <p class="text-xl text-white/90 leading-relaxed">
                        We've sent a verification link to your email address. Please verify your account to continue.
                    </p>
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">Secure account verification</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">Access to all features</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">Enhanced security for your account</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Verify Email Content -->
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
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
                        <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="mt-6 text-3xl font-bold text-secondary-800">Verify Your Email</h2>
                    <p class="mt-2 text-gray-600">Check your email for a verification link</p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="rounded-md bg-green-50 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-white py-8 px-6 shadow rounded-lg">
                    <div class="text-center
                    <p class="text-gray-600 mb-6">
                        {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you. If you didn\'t receive the email, we will be happy to send you another.') }}
                    </p>

                    <div class="mt-6">
                        <form method="POST" action="{{ route('verification.send') }}" class="inline">
                            @csrf
                            <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-primary-500 group-hover:text-primary-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </span>
                                {{ __('Resend Verification Email') }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-primary-600 hover:text-primary-500">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-6 text-center text-sm">
                    <p class="text-gray-500">
                        Didn't receive the email? Check your spam folder or
                        <button type="submit" form="resend-verification-form" class="font-medium text-primary-600 hover:text-primary-500">
                            click here to resend
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden form for the resend link -->
    <form id="resend-verification-form" method="POST" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>
</x-guest-layout>
