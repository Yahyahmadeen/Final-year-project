<x-guest-layout>
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
        <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-32 w-32"></div>
    </div>

    <style>
        .loader {
            border-top-color: #3498db;
            animation: spinner 1.5s linear infinite;
        }
        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <div class="min-h-screen flex">
        @section('title', 'Vendor Registration - ' . config('app.name'))
        
        <!-- Left Side - Background Image -->
        <div class="hidden lg:flex lg:w-1/2 relative">
            <div 
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80')"
            >
                <div class="absolute inset-0 bg-gradient-to-br from-primary-600/90 to-secondary-800/90"></div>
            </div>
            <div class="relative z-10 flex flex-col justify-center px-12 text-white">
                <div class="mb-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center space-x-3 mb-8">
                        <div class="bg-white/20 backdrop-blur-sm text-white p-4 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold">{{ config('app.name') }}</h1>
                            <p class="text-white/80">Vendor Registration</p>
                        </div>
                    </a>
                </div>
                <div class="space-y-6">
                    <h2 class="text-4xl font-bold leading-tight">
                        Start Selling on {{ config('app.name') }}
                    </h2>
                    <p class="text-xl text-white/90 leading-relaxed">
                        Join our marketplace and reach thousands of customers. Set up your vendor account in minutes and start selling your products today.
                    </p>
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">Reach thousands of potential customers</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">Powerful vendor dashboard</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">Secure payment processing</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-accent-400 rounded-full"></div>
                            <span class="text-white/90">24/7 dedicated support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
            <div class="max-w-md w-full space-y-8">
                <!-- Mobile Header -->
                <div class="text-center lg:hidden">
                    <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 mb-6">
                        <div class="bg-primary-500 text-white p-3 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-secondary-800">{{ config('app.name') }}</h1>
                            <p class="text-sm text-gray-500">Vendor Registration</p>
                        </div>
                    </a>
                </div>
                

                <!-- Header -->
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-secondary-800 mb-2">Vendor Registration</h2>
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <!-- Progress Steps -->
                <div class="mb-8">
                    <div class="flex items-center">
                        <div class="flex items-center text-primary-600">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 step-indicator" data-step="1">
                                <span class="text-sm font-medium">1</span>
                            </div>
                            <div class="text-sm font-medium ml-2">Account</div>
                        </div>
                        <div class="flex-auto border-t-2 border-gray-200 mx-2"></div>
                        <div class="flex items-center text-gray-500">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 step-indicator" data-step="2">
                                <span class="text-sm font-medium">2</span>
                            </div>
                            <div class="text-sm font-medium ml-2">Business</div>
                        </div>
                        <div class="flex-auto border-t-2 border-gray-200 mx-2"></div>
                        <div class="flex items-center text-gray-500">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 step-indicator" data-step="3">
                                <span class="text-sm font-medium">3</span>
                            </div>
                            <div class="text-sm font-medium ml-2">Complete</div>
                        </div>
                    </div>
                </div>

                <form class="mt-8 space-y-6" method="POST" action="{{ route('vendors.register.store') }}" id="vendorForm">
                    @csrf

                    <!-- Step 1: Account Information -->
                    <div class="step-content" data-step="1">
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Account Information</h3>
                            
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input id="name" name="name" type="text" required 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    value="{{ old('name') }}" placeholder="John Doe">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input id="email" name="email" type="email" required 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    value="{{ old('email') }}" placeholder="your@email.com">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input id="password" name="password" type="password" required 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="••••••••">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="••••••••">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input id="phone" name="phone" type="tel" required 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    value="{{ old('phone') }}" placeholder="+1 (555) 123-4567">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Business Information -->
                    <div class="step-content hidden" data-step="2">
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Business Information</h3>
                            
                            <!-- Store Name -->
                            <div>
                                <label for="store_name" class="block text-sm font-medium text-gray-700">Store Name</label>
                                <input id="store_name" name="store_name" type="text" 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    value="{{ old('store_name') }}" placeholder="Your store name">
                                @error('store_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Business Type -->
                            <div>
                                <label for="business_type" class="block text-sm font-medium text-gray-700">Business Type</label>
                                <select id="business_type" name="business_type"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Select business type</option>
                                    <option value="individual" {{ old('business_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="llc" {{ old('business_type') == 'llc' ? 'selected' : '' }}>LLC</option>
                                    <option value="corporation" {{ old('business_type') == 'corporation' ? 'selected' : '' }}>Corporation</option>
                                    <option value="partnership" {{ old('business_type') == 'partnership' ? 'selected' : '' }}>Partnership</option>
                                    <option value="nonprofit" {{ old('business_type') == 'nonprofit' ? 'selected' : '' }}>Non-Profit</option>
                                </select>
                                @error('business_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Business Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Business Description</label>
                                <textarea id="description" name="description" rows="3"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="Tell us about your business">{{ old('description') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Minimum 20 characters</p>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Business Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Business Address</label>
                                <input id="address" name="address" type="text" 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                    value="{{ old('address') }}" placeholder="123 Business St, City, Country">
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Complete Registration -->
                    <div class="step-content hidden" data-step="3">
                        <div class="space-y-6">
                            <div class="text-center">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="mt-3 text-lg font-medium text-gray-900">Almost there!</h3>
                                <p class="mt-2 text-sm text-gray-500">Please review your information and accept our terms to complete your registration.</p>
                            </div>

                            <!-- Review Information -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Review Your Information</h4>
                                <dl class="space-y-3">
                                    <div class="flex">
                                        <dt class="w-1/3 text-sm font-medium text-gray-500">Name</dt>
                                        <dd id="review-name" class="text-sm text-gray-900"></dd>
                                    </div>
                                    <div class="flex">
                                        <dt class="w-1/3 text-sm font-medium text-gray-500">Email</dt>
                                        <dd id="review-email" class="text-sm text-gray-900"></dd>
                                    </div>
                                    <div class="flex">
                                        <dt class="w-1/3 text-sm font-medium text-gray-500">Store Name</dt>
                                        <dd id="review-store" class="text-sm text-gray-900"></dd>
                                    </div>
                                    <div class="flex">
                                        <dt class="w-1/3 text-sm font-medium text-gray-500">Business Type</dt>
                                        <dd id="review-business-type" class="text-sm text-gray-900"></dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="pt-2">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="terms" name="terms" type="checkbox" required
                                            class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded"
                                            {{ old('terms') ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="terms" class="font-medium text-gray-700">I agree to the <a href="#" class="text-primary-600 hover:text-primary-500">Terms of Service</a> and <a href="#" class="text-primary-600 hover:text-primary-500">Privacy Policy</a></label>
                                    </div>
                                </div>
                                @error('terms')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between mt-8">
                        <button type="button" id="prevBtn" class="hidden py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Previous
                        </button>
                        <button type="button" id="nextBtn" class="ml-auto py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Next
                        </button>
                        <button type="submit" id="submitBtn" class="hidden py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <span class="flex items-center">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Submit Application
                            </span>
                        </button>
                    </div>

                    <div class="text-center text-sm mt-4">
                        <p class="text-gray-600">
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                                Sign in
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
  
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 3;
            const form = document.getElementById('vendorForm');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');
            const stepIndicators = document.querySelectorAll('.step-indicator');
            const stepContents = document.querySelectorAll('.step-content');

            // Initialize the form
            updateStepIndicators();
            showStep(currentStep);

            // Next button click handler
            nextBtn.addEventListener('click', function() {
                if (validateStep(currentStep)) {
                    showLoader();
                    // Simulate a short delay for UX
                    setTimeout(() => {
                        if (currentStep + 1 === totalSteps) {
                            updateReviewSection();
                        }
                        currentStep++;
                        showStep(currentStep);
                        updateStepIndicators();
                        hideLoader();
                    }, 300);
                }
            });

            // Show loader when form is submitted
            form.addEventListener('submit', function() {
                showLoader();
            });

            // Previous button click handler
            prevBtn.addEventListener('click', function() {
                currentStep--;
                showStep(currentStep);
                updateStepIndicators();
            });

            // Show the current step and hide others
            function showStep(step) {
                // Hide all step contents
                stepContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Show current step content
                const currentContent = document.querySelector(`.step-content[data-step="${step}"]`);
                if (currentContent) {
                    currentContent.classList.remove('hidden');
                }

                // Update button visibility
                if (step === 1) {
                    prevBtn.classList.add('hidden');
                    nextBtn.classList.remove('hidden');
                    submitBtn.classList.add('hidden');
                } else if (step === totalSteps) {
                    prevBtn.classList.remove('hidden');
                    nextBtn.classList.add('hidden');
                    submitBtn.classList.remove('hidden');
                } else {
                    prevBtn.classList.remove('hidden');
                    nextBtn.classList.remove('hidden');
                    submitBtn.classList.add('hidden');
                }

                // Scroll to top of form
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            // Update step indicators
            function updateStepIndicators() {
                stepIndicators.forEach((indicator, index) => {
                    const step = index + 1;
                    if (step < currentStep) {
                        // Completed step
                        indicator.classList.remove('bg-gray-100', 'text-gray-500');
                        indicator.classList.add('bg-green-100', 'text-green-600');
                        indicator.innerHTML = '<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>';
                    } else if (step === currentStep) {
                        // Current step
                        indicator.classList.remove('bg-gray-100', 'text-gray-500', 'bg-green-100', 'text-green-600');
                        indicator.classList.add('bg-primary-100', 'text-primary-600');
                    } else {
                        // Upcoming step
                        indicator.classList.remove('bg-primary-100', 'text-primary-600', 'bg-green-100', 'text-green-600');
                        indicator.classList.add('bg-gray-100', 'text-gray-500');
                        indicator.innerHTML = `<span class="text-sm font-medium">${step}</span>`;
                    }
                });
            }

            // Validate current step before proceeding
            function validateStep(step) {
                let isValid = true;
                const currentContent = document.querySelector(`.step-content[data-step="${step}"]`);
                if (!currentContent) return false;
                
                // Get all required inputs in current step
                const requiredInputs = currentContent.querySelectorAll('input[required], select[required], textarea[required]');
                
                requiredInputs.forEach(input => {
                    // Skip hidden fields (like hidden inputs)
                    if (input.offsetParent === null) return;
                    
                    if (!input.value.trim()) {
                        isValid = false;
                        // Add error class to the input's parent div for better visibilirty
                        const parentDiv = input.closest('div');
                        if (parentDiv) {
                            parentDiv.classList.add('error-field');
                        }
                        // Add error class to the input
                        input.classList.add('border-red-500');
                        // Add event listener to remove error class when user starts typing
                        input.addEventListener('input', function() {
                            this.classList.remove('border-red-500');
                            const parent = this.closest('div.error-field');
                            if (parent) {
                                parent.classList.remove('error-field');
                            }
                        }, { once: true });
                    }
                });

                if (!isValid) {
                    // Scroll to the first error
                    const firstError = currentContent.querySelector('.border-red-500');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return false;
                }

                return true;
            }

            // Update the review section with form data
            function showLoader() {
                document.getElementById('loading-overlay').classList.remove('hidden');
            }

            function hideLoader() {
                document.getElementById('loading-overlay').classList.add('hidden');
            }

            // Update the review section with form data
            function updateReviewSection() {
                document.getElementById('review-name').textContent = document.getElementById('name').value;
                document.getElementById('review-email').textContent = document.getElementById('email').value;
                document.getElementById('review-store').textContent = document.getElementById('store_name').value;
                
                const businessTypeSelect = document.getElementById('business_type');
                const businessTypeText = businessTypeSelect.options[businessTypeSelect.selectedIndex].text;
                document.getElementById('review-business-type').textContent = businessTypeText || 'Not specified';
            }
        });
    </script>
</x-guest-layout>
