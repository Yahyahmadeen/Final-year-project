@extends('layouts.app')

@section('title', 'Fund Wallet - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Add Funds to Your Wallet</h2>
                <p class="mt-2 text-sm text-gray-600">Enter the amount you want to add to your wallet balance</p>
                
                <div class="mt-6 bg-blue-50 rounded-xl p-4 inline-flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h2a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Current Balance: <span class="font-semibold">₦{{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <form id="fund-wallet-form" onsubmit="return false;">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount to Add</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₦</span>
                            </div>
                            <input type="number" name="amount" id="amount" 
                                   class="focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-lg py-3" 
                                   placeholder="0.00" 
                                   min="100" 
                                   step="100" 
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">NGN</span>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Minimum amount: ₦100.00</p>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    You will be redirected to a secure payment page to complete your transaction.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="error-message" class="hidden">
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700" id="error-text"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6">
                        <a href="{{ route('wallet.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Wallet
                        </a>
                        <button type="button" id="pay-button" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <span id="button-text">Continue to Payment</span>
                            <svg id="button-spinner" class="hidden ml-2 -mr-1 h-5 w-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <svg id="button-arrow" xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('amount');
        const payButton = document.getElementById('pay-button');
        const buttonText = document.getElementById('button-text');
        const buttonSpinner = document.getElementById('button-spinner');
        const buttonArrow = document.getElementById('button-arrow');
        const errorMessage = document.getElementById('error-message');
        const errorText = document.getElementById('error-text');
        
        // Format amount input
        amountInput.addEventListener('input', function(e) {
            // Ensure minimum amount of 100
            if (this.value < 100) {
                this.value = 100;
            }
            // Round to nearest 100
            this.value = Math.round(this.value / 100) * 100;
        });

        // Handle payment button click
        payButton.addEventListener('click', function() {
            const amount = amountInput.value;
            
            if (!amount || amount < 100) {
                showError('Please enter a valid amount (minimum ₦100)');
                return;
            }
            
            // Show loading state
            buttonText.textContent = 'Processing...';
            buttonSpinner.classList.remove('hidden');
            buttonArrow.classList.add('hidden');
            payButton.disabled = true;
            errorMessage.classList.add('hidden');
            
            // Show processing message
            const form = document.getElementById('fund-wallet-form');
            const processingDiv = document.createElement('div');
            processingDiv.className = 'text-center py-8';
            processingDiv.innerHTML = `
                <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-primary-500 mx-auto"></div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Preparing your payment...</h3>
                <p class="mt-2 text-sm text-gray-600">Please wait while we connect to Paystack.</p>
            `;
            
            if (form) {
                form.parentNode.insertBefore(processingDiv, form);
                form.style.display = 'none';
            }
            
            // Initialize payment
            fetch('{{ route("wallet.fund.initialize") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    amount: amount,
                    callback_url: '{{ route("wallet.fund.callback") }}'
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.message || 'Payment initialization failed'); });
                }
                return response.json();
            })
            .then(data => {
                if (data.status && data.data && data.data.authorization_url) {
                    // Update processing message
                    processingDiv.innerHTML = `
                        <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-primary-500 mx-auto"></div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Redirecting to Paystack...</h3>
                        <p class="mt-2 text-sm text-gray-600">Please wait while we redirect you to complete your payment.</p>
                    `;
                    
                    // Redirect to Paystack payment page in the same tab
                    setTimeout(() => {
                        window.location.href = data.data.authorization_url;
                    }, 1000);
                } else {
                    throw new Error(data.message || 'Unable to initialize payment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (form) form.style.display = '';
                if (processingDiv.parentNode) processingDiv.parentNode.removeChild(processingDiv);
                showError(error.message || 'An error occurred. Please try again.');
                resetButton();
            });
        });
        
        function showError(message) {
            errorText.textContent = message;
            errorMessage.classList.remove('hidden');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        function resetButton() {
            buttonText.textContent = 'Continue to Payment';
            buttonSpinner.classList.add('hidden');
            buttonArrow.classList.remove('hidden');
            payButton.disabled = false;
        }
    });

    // Check if we're returning from Paystack with a reference
    const urlParams = new URLSearchParams(window.location.search);
    const reference = urlParams.get('reference');
    
    if (reference) {
        // Show processing message
        const form = document.getElementById('fund-wallet-form');
        const processingDiv = document.createElement('div');
        processingDiv.className = 'text-center py-8';
        processingDiv.innerHTML = `
            <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-primary-500 mx-auto"></div>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Verifying your payment...</h3>
            <p class="mt-2 text-sm text-gray-600">Please wait while we verify your transaction.</p>
        `;
        
        if (form) {
            form.style.display = 'none';
            form.parentNode.insertBefore(processingDiv, form);
        } else if (document.querySelector('.bg-white')) {
            document.querySelector('.bg-white').appendChild(processingDiv);
        } else {
            document.body.insertBefore(processingDiv, document.body.firstChild);
        }
        
        // Verify payment
        verifyPayment(reference);
    }
    
    function verifyPayment(reference) {
        fetch(`/wallet/fund/verify/${reference}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status && data.redirect_url) {
                // Redirect to success page or wallet
                window.location.href = data.redirect_url;
            } else {
                throw new Error(data.message || 'Payment verification failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (processingDiv) {
                processingDiv.innerHTML = `
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">${error.message || 'Failed to verify payment. Please contact support.'}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('wallet.fund.show') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Try Again
                        </a>
                    </div>
                `;
            }
        });
    }
</script>
@endpush

@push('styles')
<style>
    .paystack-button {
        display: none !important;
    }
</style>
@endpush
@endsection
