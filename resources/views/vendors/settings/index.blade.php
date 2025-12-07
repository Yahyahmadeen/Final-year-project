@extends('layouts.vendor')

@section('title', 'Settings')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Store Settings</h1>
        <p class="text-gray-600 mt-2">Manage your store settings and preferences</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px" aria-label="Tabs">
                <button type="button" @click="activeTab = 'profile'" 
                    :class="activeTab === 'profile' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 
                            'whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm'"
                    x-on:click="activeTab = 'profile'">
                    Profile
                </button>
                <button type="button" @click="activeTab = 'store'" 
                    :class="activeTab === 'store' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 
                            'whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm'"
                    x-on:click="activeTab = 'store'">
                    Store Information
                </button>
                <button type="button" @click="activeTab = 'payments'" 
                    :class="activeTab === 'payments' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 
                            'whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm'"
                    x-on:click="activeTab = 'payments'">
                    Payment Settings
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6" x-data="{ activeTab: 'profile' }">
            <!-- Profile Tab -->
            <div x-show="activeTab === 'profile'">
                <h2 class="text-lg font-medium text-gray-900 mb-6">Profile Information</h2>
                <form action="{{ route('vendor.settings.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $vendor->phone) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <h3 class="text-md font-medium text-gray-900 mb-4">Change Password</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                    <input type="password" name="current_password" id="current_password" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                        <input type="password" name="new_password" id="new_password" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                        @error('new_password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Store Information Tab -->
            <div x-show="activeTab === 'store'" x-cloak>
                <h2 class="text-lg font-medium text-gray-900 mb-6">Store Information</h2>
                <form action="{{ route('vendor.settings.store.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-6">
                            <div class="flex-shrink-0">
                                <img class="h-24 w-24 rounded-lg object-cover" 
                                     src="{{ $vendor->logo ? asset('storage/' . $vendor->logo) : 'https://via.placeholder.com/150' }}" 
                                     alt="Store logo">
                            </div>
                            <div class="flex-1">
                                <label for="logo" class="block text-sm font-medium text-gray-700">Store Logo</label>
                                <div class="mt-1 flex items-center">
                                    <input type="file" name="logo" id="logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">JPG, PNG, or GIF (Max: 2MB)</p>
                                @error('logo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="store_name" class="block text-sm font-medium text-gray-700">Store Name</label>
                            <input type="text" name="store_name" id="store_name" value="{{ old('store_name', $vendor->store_name) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            @error('store_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Store Description</label>
                            <textarea name="description" id="description" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old('description', $vendor->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" name="address" id="address" value="{{ old('address', $vendor->address) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" id="city" value="{{ old('city', $vendor->city) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700">State/Province</label>
                                <input type="text" name="state" id="state" value="{{ old('state', $vendor->state) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                @error('state')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <select name="country" id="country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    <option value="">Select Country</option>
                                    @foreach(['Nigeria', 'Ghana', 'Kenya', 'South Africa', 'United States', 'United Kingdom'] as $country)
                                        <option value="{{ $country }}" {{ old('country', $vendor->country) === $country ? 'selected' : '' }}>{{ $country }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $vendor->postal_code) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                @error('postal_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Payment Settings Tab -->
            <div x-show="activeTab === 'payments'" x-cloak>
                <h2 class="text-lg font-medium text-gray-900 mb-6">Payment Settings</h2>
                <form action="{{ route('vendor.settings.payments.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Your payment information is encrypted and securely stored. We do not store your full bank account details.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $vendor->paymentSettings->bank_name ?? '') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                @error('bank_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="account_name" class="block text-sm font-medium text-gray-700">Account Name</label>
                                <input type="text" name="account_name" id="account_name" value="{{ old('account_name', $vendor->paymentSettings->account_name ?? '') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                @error('account_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="account_number" class="block text-sm font-medium text-gray-700">Account Number</label>
                                <input type="text" name="account_number" id="account_number" value="{{ old('account_number', $vendor->paymentSettings->account_number ?? '') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                @error('account_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="routing_number" class="block text-sm font-medium text-gray-700">Routing Number</label>
                                <input type="text" name="routing_number" id="routing_number" value="{{ old('routing_number', $vendor->paymentSettings->routing_number ?? '') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                @error('routing_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="swift_code" class="block text-sm font-medium text-gray-700">SWIFT/BIC Code</label>
                                <input type="text" name="swift_code" id="swift_code" value="{{ old('swift_code', $vendor->paymentSettings->swift_code ?? '') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                @error('swift_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="paypal_email" class="block text-sm font-medium text-gray-700">PayPal Email (Optional)</label>
                                <input type="email" name="paypal_email" id="paypal_email" value="{{ old('paypal_email', $vendor->paymentSettings->paypal_email ?? '') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                @error('paypal_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Save Payment Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('settings', () => ({
            activeTab: 'profile',
            
            init() {
                // Check if there's a hash in the URL and set the active tab accordingly
                const hash = window.location.hash.substring(1);
                if (['profile', 'store', 'payments'].includes(hash)) {
                    this.activeTab = hash;
                }
                
                // Update URL when tab changes
                this.$watch('activeTab', (value) => {
                    window.location.hash = value;
                });
                
                // Handle browser back/forward buttons
                window.addEventListener('popstate', () => {
                    const hash = window.location.hash.substring(1);
                    if (['profile', 'store', 'payments'].includes(hash)) {
                        this.activeTab = hash;
                    }
                });
            }
        }));
    });
</script>
@endpush
@endsection