<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayoutRequest;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PayoutController extends Controller
{
    /**
     * Display a listing of pending payout requests.
     */
    public function index()
    {
        $payouts = PayoutRequest::with('vendor')
            ->latest()
            ->paginate(20);
            
        return view('admin.payouts.index', compact('payouts'));
    }
    
    /**
     * Show payout request details.
     */
    public function show(PayoutRequest $payout)
    {
        return view('admin.payouts.show', compact('payout'));
    }
    
    /**
     * Approve a payout request.
     */
    public function approve(Request $request, PayoutRequest $payout)
    {
        // Validate admin notes
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);
        
        // Check if already processed
        if ($payout->status !== 'pending') {
            return back()->with('error', 'This payout request has already been processed.');
        }
        
        DB::beginTransaction();
        
        try {
            // Update payout status to approved
            $payout->update([
                'status' => 'completed',
                'admin_notes' => $request->admin_notes,
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);
            
            // Update the vendor wallet transaction to completed
            VendorWalletTransaction::where('reference', $payout->reference)
                ->update([
                    'status' => 'completed',
                    'description' => 'Payout request approved: ' . $payout->reference
                ]);
            
            DB::commit();
            
            return redirect()->route('admin.payouts.index')
                ->with('success', 'Payout request approved successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payout approval error: ' . $e->getMessage());
            
            return $e;
            return back()->with('error', 'An error occurred while processing this request.');
        }
    }
    
    /**
     * Reject a payout request and refund the vendor.
     */
    public function reject(Request $request, PayoutRequest $payout)
    {
        // Validate admin notes
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);
        
        // Check if already processed
        if ($payout->status !== 'pending') {
            return back()->with('error', 'This payout request has already been processed.');
        }
        
        DB::beginTransaction();
        
        try {
            // Get vendor wallet
            $vendorWallet = VendorWallet::where('vendor_id', $payout->vendor_id)->first();
            
            if (!$vendorWallet) {
                throw new \Exception('Vendor wallet not found.');
            }
            
            // Refund the amount back to vendor wallet
            $vendorWallet->increment('balance', $payout->amount);
            
            // Create refund transaction
            $vendorWallet->transactions()->create([
                'amount' => $payout->amount,
                'type' => 'credit',
                'description' => 'Payout request rejected and refunded: ' . $payout->reference,
                'status' => 'completed',
                'reference' => 'REFUND-' . $payout->reference,
            ]);
            
            // Update payout status to rejected
            $payout->update([
                'status' => 'rejected',
                'admin_notes' => $request->admin_notes,
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);
            
            // Update the original transaction to rejected
            VendorWalletTransaction::where('reference', $payout->reference)
                ->update([
                    'status' => 'rejected',
                    'description' => 'Payout request rejected: ' . $payout->reference
                ]);
            
            DB::commit();
            
            return redirect()->route('admin.payouts.index')
                ->with('success', 'Payout request rejected and amount refunded to vendor wallet.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payout rejection error: ' . $e->getMessage());
            
            return back()->with('error', 'An error occurred while processing this request.');
        }
    }
}
