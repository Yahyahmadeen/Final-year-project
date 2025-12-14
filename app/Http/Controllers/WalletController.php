<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Models\PayoutRequest;
use Illuminate\Support\Facades\DB;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;
        
        // Get or create vendor wallet
        $vendorWallet = VendorWallet::firstOrCreate(
            ['vendor_id' => $vendor->id],
            ['balance' => 0]
        );

        $stats = [
            'balance' => $vendorWallet->balance ?? 0,
            'total_earnings' => VendorWalletTransaction::where('vendor_wallet_id', $vendorWallet->id)
                ->where('type', 'credit')
                ->sum('amount'),
            'total_withdrawn' => VendorWalletTransaction::where('vendor_wallet_id', $vendorWallet->id)
                ->where('type', 'debit')
                ->where('description', 'like', '%payout%')
                ->sum('amount'),
            'pending_payouts' => PayoutRequest::where('vendor_id', $vendor->id)
                ->where('status', 'pending')
                ->sum('amount') ?? 0,
        ];

        $recentTransactions = VendorWalletTransaction::where('vendor_wallet_id', $vendorWallet->id)
            ->latest()
            ->paginate(10);

        return view('vendors.wallet.index', compact('stats', 'recentTransactions', 'vendorWallet'));
    }

    public function payoutHistory()
    {
        $vendor = auth()->user()->vendor;
        $payouts = $vendor->payoutRequests()->latest()->paginate(15);

        return view('vendors.wallet.payout_history', compact('payouts'));
    }

    public function requestPayout()
    {
        $vendor = auth()->user()->vendor;
        
        // Get vendor wallet
        $vendorWallet = VendorWallet::firstOrCreate(
            ['vendor_id' => $vendor->id],
            ['balance' => 0]
        );
        
        return view('vendors.wallet.request_payout', compact('vendorWallet'));
    }

    public function storePayoutRequest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|size:10|regex:/^[0-9]{10}$/',
            'account_name' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        $vendor = auth()->user()->vendor;
        $amount = $request->amount;
        
        // Start database transaction
        DB::beginTransaction();
        
        try {
            // Get vendor wallet
            $vendorWallet = VendorWallet::where('vendor_id', $vendor->id)->first();
            
            if (!$vendorWallet || $amount > $vendorWallet->balance) {
                return back()->withErrors(['amount' => 'Insufficient balance.']);
            }
            
            // Deduct amount from vendor wallet immediately
            $vendorWallet->decrement('balance', $amount);
            
            // Record transaction in vendor wallet
            $vendorWallet->transactions()->create([
                'amount' => $amount,
                'type' => 'debit',
                'description' => 'Payout request (pending)',
                'status' => 'pending',
                'reference' => 'PAYOUT-' . strtoupper(uniqid()),
            ]);

            // Generate unique reference
            $reference = 'PAYOUT-' . strtoupper(uniqid());

            // Create payout request
            PayoutRequest::create([
                'vendor_id' => $vendor->id,
                'amount' => $amount,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'reference' => $reference,
                'notes' => 'Amount deducted from wallet and held pending approval',
            ]);
            
            // Commit transaction
            DB::commit();

            return redirect()->route('vendor.wallet.payout.history')
                ->with('success', 'Payout request submitted successfully. Reference: ' . $reference . '. Amount has been temporarily held from your wallet pending approval.');
                
        } catch (\Exception $e) {
            // Rollback in case of error
            DB::rollBack();
            \Log::error('Payout request error: ' . $e->getMessage());
            
            return back()->withErrors(['general' => 'An error occurred while processing your request. Please try again.']);
        }
    }
    //
}
