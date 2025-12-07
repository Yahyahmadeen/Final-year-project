<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Models\PayoutRequest;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;
        $wallet = $vendor->wallet;

        $stats = [
            'balance' => $wallet->balance ?? 0,
            'total_earnings' => $vendor->walletTransactions()->where('transaction_type', 'credit')->sum('amount'),
            'total_withdrawn' => $vendor->walletTransactions()->where('transaction_type', 'debit')->where('description', 'payout')->sum('amount'),
            'pending_payouts' => $vendor->payoutRequests()->where('status', 'pending')->sum('amount'),
        ];

        $recentTransactions = $vendor->walletTransactions()->latest()->take(5)->get();

        return view('vendors.wallet.index', compact('stats', 'recentTransactions'));
    }

    public function payoutHistory()
    {
        $vendor = auth()->user()->vendor;
        $payouts = $vendor->payoutRequests()->latest()->paginate(15);

        return view('vendors.wallet.payout_history', compact('payouts'));
    }

    public function requestPayout()
    {
        return view('vendors.wallet.request_payout');
    }

    public function storePayoutRequest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ]);

        $vendor = auth()->user()->vendor;
        $wallet = $vendor->wallet;

        if ($request->amount > $wallet->balance) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        $vendor->payoutRequests()->create([
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        return redirect()->route('vendor.wallet.payout.history')->with('success', 'Payout request submitted successfully.');
    }
    //
}
