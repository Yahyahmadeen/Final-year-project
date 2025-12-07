<x-guest-layout>
    <div class="min-h-screen flex">
        @section('title', 'Register - ' . config('app.name'))
        
        <!-- Left Side - Background Image -->
        <div class="hidden lg:flex lg:w-1/2 relative">
            <div 
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80')"
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
                        Join our growing community
                    </h2>
                    <p class="text-xl text-white/90 leading-relaxed">
                        Create your account today and get access to exclusive deals, trusted vendors, and a seamless shopping experience.
                    </p>
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">Access to 1000+ verified vendors</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">Secure payment processing</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">24/7 customer support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
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
                    <h2 class="text-3xl font-bold text-secondary-800 mb-2">Create your account</h2>
                    <p class="text-gray-600">Join us and start your shopping journey</p>
                </div>

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="rounded-md shadow-sm space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="sr-only">Full Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input id="name" name="name" type="text" autocomplete="name" required 
                                    class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                    placeholder="Full name" value="{{ old('name') }}" autofocus>
                            </div>
                        </div>

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
                                    placeholder="Email address" value="{{ old('email') }}">
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" autocomplete="new-password" required 
                                    class="appearance-none block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                    placeholder="Password">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                                    <svg id="eye-icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                    <svg id="eye-slash-icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-gray-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="sr-only">Confirm Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                                    class="appearance-none block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                    placeholder="Confirm Password">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password_confirmation')">
                                    <svg id="eye-icon-password_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                    <svg id="eye-slash-icon-password_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-gray-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Vendor Registration Toggle -->
                    <div class="relative flex items-start py-2">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="vendor-toggle" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="vendor-toggle" class="font-medium text-gray-700">Register as a Vendor</label>
                            <p class="text-gray-500">Sell your products on our platform and reach thousands of customers</p>
                        </div>
                    </div>

                    <!-- Vendor Registration Button -->
                    <div id="vendor-registration-container" class="hidden">
                        <div class="mt-4 p-4 border border-dashed border-gray-300 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-600 mb-4">To register as a vendor, please provide additional information about your business.</p>
                            <a href="{{ route('vendors.register') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Continue Vendor Registration
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="terms" name="terms" type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" required>
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                I agree to the <a href="#" class="text-primary-600 hover:text-primary-500">Terms</a> and <a href="#" class="text-primary-600 hover:text-primary-500">Privacy Policy</a>
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-primary-500 group-hover:text-primary-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            {{ __('Create Account') }}
                        </button>
                    </div>
                </form>

                <div class="text-center space-y-4">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                            Sign in
                        </a>
                    </p>
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-gray-50 text-gray-500">Vendors</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">
                        Want to become a vendor? 
                        <a href="{{ route('vendors.register') }}" class="font-medium text-primary-600 hover:text-primary-500">
                            Apply as a Vendor
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const eyeIcon = document.getElementById('eye-icon-' + fieldId);
            const eyeSlashIcon = document.getElementById('eye-slash-icon-' + fieldId);
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }

        // Toggle vendor registration section
        document.addEventListener('DOMContentLoaded', function() {
            const vendorToggle = document.getElementById('vendor-toggle');
            const vendorContainer = document.getElementById('vendor-registration-container');
            const registerForm = document.querySelector('form[action$="register"]');
            const registerButton = registerForm ? registerForm.querySelector('button[type="submit"]') : null;

            if (vendorToggle && vendorContainer) {
                vendorToggle.addEventListener('change', function() {
                    if (this.checked) {
                        vendorContainer.classList.remove('hidden');
                        if (registerButton) {
                            registerButton.disabled = true;
                            registerButton.classList.add('opacity-50', 'cursor-not-allowed');
                        }
                    } else {
                        vendorContainer.classList.add('hidden');
                        if (registerButton) {
                            registerButton.disabled = false;
                            registerButton.classList.remove('opacity-50', 'cursor-not-allowed');
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-guest-layout>
