@extends('layouts.vendor')

@section('title', 'Request Payout')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <a href="{{ route('vendor.wallet.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600 mb-4">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Wallet
        </a>
        <h1 class="text-3xl font-bold text-secondary-800">Request Payout</h1>
        <p class="text-gray-600 mt-1">Withdraw your earnings to your bank account</p>
    </div>

    <!-- Balance Info -->
    <div class="bg-green-500 bg-green-600 rounded-2xl shadow-lg p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-white/80 mb-2">Available Balance</p>
                <p class="text-4xl font-bold">₦{{ number_format($vendorWallet->balance ?? 0, 2) }}</p>
            </div>
            <div class="p-4 bg-white/20 rounded-xl">
                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Payout Form -->
    <form method="POST" action="{{ route('vendor.wallet.payout.store') }}" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-xl font-semibold text-secondary-800 mb-6">Payout Details</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Amount (₦) *</label>
                    <input type="number" name="amount" step="0.01" min="1000" max="{{ $vendorWallet->balance ?? 0 }}" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-lg font-semibold"
                           placeholder="Enter amount">
                    <p class="text-xs text-gray-500 mt-2">Minimum: ₦1,000.00 • Maximum: ₦{{ number_format($vendorWallet->balance ?? 0, 2) }}</p>
                    @error('amount')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bank Name *</label>
                    <select name="bank_name" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Select your bank</option>
                        <option value="Access Bank">Access Bank</option>
                        <option value="Citibank">Citibank</option>
                        <option value="Ecobank Nigeria">Ecobank Nigeria</option>
                        <option value="Fidelity Bank">Fidelity Bank</option>
                        <option value="First Bank of Nigeria">First Bank of Nigeria</option>
                        <option value="First City Monument Bank (FCMB)">First City Monument Bank (FCMB)</option>
                        <option value="Globus Bank">Globus Bank</option>
                        <option value="Guaranty Trust Bank (GTBank)">Guaranty Trust Bank (GTBank)</option>
                        <option value="Heritage Bank">Heritage Bank</option>
                        <option value="Keystone Bank">Keystone Bank</option>
                        <option value="Kuda Bank">Kuda Bank</option>
                        <option value="Opay">Opay</option>
                        <option value="PalmPay">PalmPay</option>
                        <option value="Parallex Bank">Parallex Bank</option>
                        <option value="Polaris Bank">Polaris Bank</option>
                        <option value="Providus Bank">Providus Bank</option>
                        <option value="Stanbic IBTC Bank">Stanbic IBTC Bank</option>
                        <option value="Standard Chartered Bank">Standard Chartered Bank</option>
                        <option value="Sterling Bank">Sterling Bank</option>
                        <option value="SunTrust Bank">SunTrust Bank</option>
                        <option value="Titan Trust Bank">Titan Trust Bank</option>
                        <option value="Union Bank of Nigeria">Union Bank of Nigeria</option>
                        <option value="United Bank for Africa (UBA)">United Bank for Africa (UBA)</option>
                        <option value="Unity Bank">Unity Bank</option>
                        <option value="Wema Bank">Wema Bank</option>
                        <option value="Zenith Bank">Zenith Bank</option>
                    </select>
                    @error('bank_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Account Number *</label>
                    <input type="text" name="account_number" required maxlength="10" pattern="[0-9]{10}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="Enter 10-digit account number">
                    <p class="text-xs text-gray-500 mt-1">Enter your 10-digit bank account number</p>
                    @error('account_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Account Name *</label>
                    <input type="text" name="account_name" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="Enter account name as it appears on your bank account">
                    <p class="text-xs text-gray-500 mt-1">Must match the name on your bank account</p>
                    @error('account_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <input type="text" name="payment_method" value="Bank Transfer" readonly
                           class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-xl text-gray-600">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between pt-6">
            <a href="{{ route('vendor.wallet.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all shadow-lg">
                Submit Payout Request
            </button>
        </div>
    </form>
</div>
@endsection
