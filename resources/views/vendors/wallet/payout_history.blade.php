@extends('layouts.vendor')

@section('title', 'Payout History')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <a href="{{ route('vendor.wallet.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600 mb-4">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Wallet
    </a>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-secondary-800">Payout History</h1>
            <p class="text-gray-600 mt-1">Track all your withdrawal requests</p>
        </div>
        <a href="{{ route('vendor.wallet.payout.request') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all shadow-lg">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Request Payout
        </a>
    </div>
</div>

<!-- Payouts List -->
<div class="space-y-4">
    @forelse($payouts as $payout)
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-3">
                    <h3 class="text-xl font-bold text-secondary-800">₦{{ number_format($payout->amount, 2) }}</h3>
                    <span class="px-3 py-1 rounded-full text-xs font-medium 
                        @switch($payout->status)
                            @case('completed') bg-green-100 text-green-800 @break
                            @case('pending') bg-yellow-100 text-yellow-800 @break
                            @case('processing') bg-blue-100 text-blue-800 @break
                            @default bg-red-100 text-red-800
                        @endswitch
                    ">
                        {{ ucfirst($payout->status) }}
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Requested On</p>
                        <p class="text-sm text-gray-900">{{ $payout->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Payment Method</p>
                        <p class="text-sm text-gray-900">{{ $payout->payment_method }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-sm p-16 border border-gray-100 text-center">
        <svg class="h-20 w-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-gray-600 text-lg mb-2">No payout requests yet</p>
        <p class="text-gray-500 text-sm mb-6">Request your first payout to see it here</p>
        <a href="{{ route('vendor.wallet.payout.request') }}" class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition-colors">
            Request Payout
        </a>
    </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $payouts->links() }}
</div>
@endsection
