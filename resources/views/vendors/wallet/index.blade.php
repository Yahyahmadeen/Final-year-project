@extends('layouts.vendor')

@section('title', 'Wallet')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-secondary-800">Wallet</h1>
    <p class="text-gray-600 mt-1">Manage your earnings and request payouts</p>
</div>

<!-- Wallet Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Available Balance -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-white/20 rounded-xl">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-sm text-white/80">Available Balance</p>
        <p class="text-3xl font-bold mt-1">₦{{ number_format($stats['balance'], 2) }}</p>
        <p class="text-xs text-white/70 mt-2">Ready to withdraw</p>
    </div>

    <!-- Total Earnings -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-100 rounded-xl">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
        <p class="text-sm text-gray-600">Total Earnings</p>
        <p class="text-2xl font-bold text-secondary-800 mt-1">₦{{ number_format($stats['total_earnings'], 2) }}</p>
        <p class="text-xs text-gray-500 mt-2">All time</p>
    </div>

    <!-- Total Withdrawn -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-purple-100 rounded-xl">
                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
        </div>
        <p class="text-sm text-gray-600">Total Withdrawn</p>
        <p class="text-2xl font-bold text-secondary-800 mt-1">₦{{ number_format($stats['total_withdrawn'], 2) }}</p>
        <p class="text-xs text-gray-500 mt-2">Completed payouts</p>
    </div>

    <!-- Pending Payouts -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-yellow-100 rounded-xl">
                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-sm text-gray-600">Pending Payouts</p>
        <p class="text-2xl font-bold text-secondary-800 mt-1">₦{{ number_format($stats['pending_payouts'], 2) }}</p>
        <p class="text-xs text-gray-500 mt-2">Being processed</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('vendor.wallet.payout.request') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl shadow-lg p-6 text-white hover:from-primary-600 hover:to-primary-700 transition-all">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-white/20 rounded-xl">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-lg">Request Payout</p>
                <p class="text-sm text-white/80">Withdraw your earnings</p>
            </div>
        </div>
    </a>

    <a href="#" class="bg-white rounded-2xl shadow-sm p-6 border border-gray-200 hover:border-primary-500 hover:shadow-md transition-all">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-blue-100 rounded-xl">
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-lg text-secondary-800">Transactions</p>
                <p class="text-sm text-gray-600">View transaction history</p>
            </div>
        </div>
    </a>

    <a href="{{ route('vendor.wallet.payout.history') }}" class="bg-white rounded-2xl shadow-sm p-6 border border-gray-200 hover:border-primary-500 hover:shadow-md transition-all">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-purple-100 rounded-xl">
                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-lg text-secondary-800">Payout History</p>
                <p class="text-sm text-gray-600">Track your withdrawals</p>
            </div>
        </div>
    </a>
</div>

<!-- Recent Transactions -->
<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-secondary-800">Recent Transactions</h2>
        <a href="#" class="text-primary-500 text-sm hover:text-primary-600 font-medium">View All →</a>
    </div>

    @if($recentTransactions->count())
    <div class="space-y-3">
        @foreach($recentTransactions as $txn)
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
            <div class="flex items-center space-x-3">
                <div class="p-2 @if($txn->type == 'credit') bg-green-100 @else bg-red-100 @endif rounded-lg">
                    <svg class="h-5 w-5 @if($txn->type == 'credit') text-green-600 @else text-red-600 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($txn->type == 'credit')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        @endif
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-secondary-800 text-sm">{{ Str::limit($txn->description, 50) }}</p>
                    <p class="text-xs text-gray-500">{{ $txn->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
            <p class="font-bold @if($txn->type == 'credit') text-green-600 @else text-red-600 @endif">
                @if($txn->type == 'credit') + @else - @endif ₦{{ number_format($txn->amount, 2) }}
            </p>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12">
        <svg class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <p class="text-gray-600">No transactions yet</p>
    </div>
    @endif
</div>
@endsection
