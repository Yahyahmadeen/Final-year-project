@extends('layouts.app')

@section('content')
@push('scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('amount_fund');
        const payButton = document.getElementById('pay-button');
        const buttonText = document.getElementById('button-text');
        const buttonSpinner = document.getElementById('button-spinner');
        const errorMessage = document.getElementById('error-message');
        const errorText = document.getElementById('error-text');
        
        // Format amount input
        // amountInput.addEventListener('input', function(e) {
        //     // Ensure minimum amount of 100
        //     if (this.value < 100) {
        //         this.value = 100;
        //     }
        //     // Round to nearest 100
        //     this.value = Math.round(this.value / 100) * 100;
        // });

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
            payButton.disabled = true;
            errorMessage.classList.add('hidden');
            
            // Initialize payment
            fetch('{{ route("wallet.fund.initialize") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ amount: amount })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status && data.data) {
                    // Redirect to Paystack payment page
                    const handler = PaystackPop.setup({
                        key: '{{ config("services.paystack.public_key") }}',
                        email: '{{ auth()->user()->email }}',
                        amount: data.data.amount,
                        ref: data.data.reference,
                        callback: function(response) {
                            // This will be handled by the callback URL
                        },
                        onClose: function() {
                            // Handle when the user closes the payment modal
                            resetButton();
                        },
                    });
                    // handler.openIframe();
                    if (data.status && data.data && data.data.authorization_url) {
                                                                                                    
                    // Redirect to Paystack payment page in the same tab
                    setTimeout(() => {
                        window.location.href = data.data.authorization_url;
                    }, 1000);
                } else {
                    throw new Error(data.message || 'Unable to initialize payment');
                }
                } else {
                    throw new Error(data.message || 'Unable to initialize payment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
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
            buttonText.textContent = 'Fund with Paystack';
            buttonSpinner.classList.add('hidden');
            payButton.disabled = false;
        }
    });
</script>
@endpush
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-semibold text-gray-900">My Wallet</h1>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Wallet Balance -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-lg font-medium text-gray-900">Current Balance</h2>
            <p class="mt-2 text-3xl font-bold text-primary-600">₦{{ number_format($wallet->balance ?? 0, 2) }}</p>
        </div>

        <!-- Fund Wallet -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-lg font-medium text-gray-900">Fund Wallet</h2>
            <form id="fund-wallet-form" class="mt-4">
                @csrf
                <div>
                    <label for="amount_fund" class="sr-only">Amount</label>
                    <input type="number" name="amount" id="amount_fund" min="100" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm" placeholder="Enter amount (min: ₦100)" required>
                </div>
                <button type="button" id="pay-button" class="mt-4 w-full bg-primary-600 text-white py-2 px-4 rounded-md hover:bg-primary-700 flex items-center justify-center">
                    <span id="button-text">Fund with Paystack</span>
                    <svg id="button-spinner" class="hidden ml-2 -mr-1 h-5 w-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
            <div id="error-message" class="hidden mt-4 p-4 bg-red-50 border-l-4 border-red-400 rounded-r-lg">
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

        <!-- Transfer Funds -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-lg font-medium text-gray-900">Transfer Funds</h2>
            <form action="{{ route('wallet.transfer') }}" method="POST" class="mt-4">
                @csrf
                <div>
                    <label for="recipient_email" class="sr-only">Recipient Email</label>
                    <input type="email" name="recipient_email" id="recipient_email" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm" placeholder="Recipient's email">
                </div>
                <div class="mt-4">
                    <label for="amount_transfer" class="sr-only">Amount</label>
                    <input type="number" name="amount" id="amount_transfer" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm" placeholder="Amount">
                </div>
                <button type="submit" class="mt-4 w-full bg-secondary-600 text-white py-2 px-4 rounded-md hover:bg-secondary-700">Transfer</button>
            </form>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="mt-8 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Transaction History</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $transaction->amount > 0 ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($transaction->type) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $transaction->amount > 0 ? 'text-green-600' : 'text-red-600' }}">₦{{ number_format(abs($transaction->amount), 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->description }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No transactions yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
