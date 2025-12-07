@extends('layouts.vendor')

@section('title', 'Wallet Transactions')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <a href="{{ route('vendor.wallet.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600 mb-4">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Wallet
    </a>
    <h1 class="text-3xl font-bold text-secondary-800">Transaction History</h1>
    <p class="text-gray-600 mt-1">View all your wallet transactions</p>
</div>

<!-- Transactions Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-secondary-800">All Transactions</h2>
    </div>
    
    @if($transactions->count())
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Description</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Balance</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($transactions as $txn)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $txn->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $txn->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="p-2 @if($txn->type == 'credit') bg-green-100 @else bg-red-100 @endif rounded-lg mr-3">
                                <svg class="h-4 w-4 @if($txn->type == 'credit') text-green-600 @else text-red-600 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($txn->type == 'credit')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    @endif
                                </svg>
                            </div>
                            <span class="text-sm font-medium @if($txn->type == 'credit') text-green-600 @else text-red-600 @endif">
                                {{ ucfirst($txn->type) }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ Str::limit($txn->description, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-bold @if($txn->type == 'credit') text-green-600 @else text-red-600 @endif">
                            @if($txn->type == 'credit') + @else - @endif ₦{{ number_format($txn->amount, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">₦{{ number_format($txn->balance_after, 2) }}</div>
                        <div class="text-xs text-gray-500">After</div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-16">
        <svg class="h-20 w-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <p class="text-gray-600 text-lg mb-2">No transactions found</p>
        <p class="text-gray-500 text-sm">Your transaction history will appear here</p>
    </div>
    @endif
</div>

<div class="mt-8">
    {{ $transactions->links() }}
</div>
@endsection
