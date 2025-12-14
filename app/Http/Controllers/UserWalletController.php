<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserWallet;
use App\Models\UserWalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class UserWalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get or create wallet
        $wallet = UserWallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );
        
        // Get paginated transactions
        $transactions = $wallet->transactions()->latest()->paginate(10);

        return view('wallet.index', compact('wallet', 'transactions'));
    }

    /**
     * Show the form for funding the wallet.
     *
     * @return \Illuminate\View\View
     */
    public function showFundForm()
    {
        return view('wallet.fund');
    }

    /**
     * Process wallet funding.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * Initialize Paystack payment
     */
    public function initializePayment(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100|max:10000000', // Max 10,000,000 Naira
        ]);

        $user = $request->user();
        $amount = (int) ($validated['amount'] * 100); // Convert to kobo (smallest currency unit)
        $reference = 'WLT' . strtoupper(Str::random(10));
        
        DB::beginTransaction();
        
        try {
            // Ensure amount is an integer in kobo (smallest currency unit for NGN)
            $amountInKobo = (int) round($amount);
            
            if ($amountInKobo < 100) { // Minimum amount is 100 kobo (1 NGN)
                throw new \Exception('Amount must be at least ₦1');
            }

            // Create a payment record
            $payment = Payment::create([
                'user_id' => $user->id,
                'reference' => $reference,
                'amount' => $amountInKobo / 100, // Store in Naira
                'status' => 'pending',
                'gateway' => 'paystack',
                'currency' => 'NGN',
                'description' => 'Wallet Funding',
                'metadata' => [
                    'purpose' => 'wallet_funding',
                    'amount_in_kobo' => $amountInKobo
                ]
            ]);

            // Prepare Paystack payment details
            $paymentData = [
                'email' => $user->email,
                'amount' => $amountInKobo, // Must be in kobo
                'reference' => $reference,
                'currency' => 'NGN',
                'callback_url' => route('wallet.fund.callback'),
                'metadata' => [
                    'payment_id' => $payment->id,
                    'purpose' => 'wallet_funding',
                    'user_id' => $user->id,
                    'amount_in_kobo' => $amountInKobo
                ]
            ];

            // Initialize Paystack payment
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.paystack.secret_key'),
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache',
            ])
            ->timeout(30)
            ->post('https://api.paystack.co/transaction/initialize', $paymentData);
            
            \Log::info('Paystack response', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            $responseData = $response->json();

            if (!$response->successful() || !$responseData['status']) {
                throw new \Exception($responseData['message'] ?? 'Failed to initialize payment');
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Payment initialized successfully',
                'data' => [
                    'authorization_url' => $responseData['data']['authorization_url'],
                    'amount' => $amountInKobo,
                    'reference' => $reference
                ]]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment initialization failed: ' . $e->getMessage());
            \Log::error($e);
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Handle Paystack callback
     */
    public function handleCallback(Request $request)
    {
        $reference = $request->query('reference');
        if (!$reference) {
            return redirect()->route('wallet.index')
            ->with('error', 'Invalid payment reference');
        }
        
        DB::beginTransaction();
        
        try {
            // Verify payment with Paystack
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.paystack.secret_key'),
                'Cache-Control' => 'no-cache',
            ])
            ->timeout(30)
            ->get("https://api.paystack.co/transaction/verify/" . $reference);

            
            $responseData = $response->json();
            
            if (!$response->successful() || !$responseData['status']) {
                throw new \Exception('Payment verification failed: ' . ($responseData['message'] ?? 'Unknown error'));
            }
            
            $transactionData = $responseData['data'];
            
            
            // Find the payment record
            $payment = Payment::where('reference', $reference)->firstOrFail();
            
            // Check if payment was already processed
            if ($payment->status === 'success') {
                return redirect()->route('wallet.index')
                    ->with('success', 'Payment already processed successfully');
            }
            
            // Update payment status
            $payment->update([
                'status' => strtolower($transactionData['status']),
                'gateway_reference' => $transactionData['reference'],
                'paid_at' => now(),
                'metadata' => array_merge($payment->metadata ?? [], [
                    'gateway_response' => $transactionData
                ])
            ]);
            
            // If payment was successful, update wallet
            if ($transactionData['status'] === 'success') {
                $user = $payment->user;
                $amount = $payment->amount;
                
                // Get or create user's wallet
                $wallet = UserWallet::firstOrCreate(
                    ['user_id' => $user->id],
                    ['balance' => 0]
                );
                
                // Update wallet balance
                $wallet->increment('balance', $amount);
                
                // Record transaction
                UserWalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'type' => 'credit',
                    'amount' => $amount,
                    'description' => 'Wallet funding via Paystack',
                    'related_type' => 'payment',  // More descriptive than just 'credit'
                    'related_id' => $payment->id, // Store payment ID as related ID
                    'reference' => $reference,    // Added in our migration
                    'status' => 'completed',      // Added in our migration
                    'metadata' => [               // Added in our migration
                        'payment_id' => $payment->id,
                        'gateway' => 'paystack',
                        'gateway_reference' => $transactionData['reference']
                    ]
                ]);
                
                // Update payment status to completed
                $payment->update(['status' => 'success']);
                
                DB::commit();
                
                // Check for redirect URL in session
                $redirectUrl = session('redirect_after_payment', route('wallet.index'));
                
                return redirect($redirectUrl)
                    ->with('success', 'Wallet funded successfully!');
            }
            
            DB::commit();
            
            return redirect()->route('wallet.index')
                ->with('error', 'Payment was not successful: ' . ($transactionData['gateway_response'] ?? 'Unknown error'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Paystack Callback Error: ' . $e->getMessage());
            \Log::error('Reference: ' . $reference);
            \Log::error('Response: ' . ($responseData ?? 'No response'));
            
            return redirect()->route('wallet.index')
                ->with('error', 'Error processing payment: ' . $e->getMessage());
        }
        
        if (!$reference) {
            return redirect()->route('wallet.index')
                ->with('error', 'Invalid payment reference');
        }

        $paystack = new \Yabacon\Paystack(env('PAYSTACK_SECRET_KEY'));
        
        try {
            $response = $paystack->transaction->verify(['reference' => $reference]);
            
            if (!$response->status) {
                throw new \Exception('Invalid payment verification response');
            }

            $payment = Payment::where('reference', $reference)->firstOrFail();
            
            if ($payment->status === 'success') {
                return redirect()->route('wallet.index')
                    ->with('success', 'Payment already processed successfully');
            }

            if ($response->data->status === 'success') {
                return DB::transaction(function () use ($payment, $response) {
                    // Update payment status
                    $payment->update([
                        'status' => 'success',
                        'gateway_reference' => $response->data->reference,
                        'paid_at' => now(),
                        'metadata' => array_merge(
                            $payment->metadata ?? [],
                            ['paystack_response' => $response->data]
                        )
                    ]);

                    // Get or create user wallet
                    $wallet = $payment->user->wallet ?? $payment->user->wallet()->create(['balance' => 0]);
                    
                    // Update wallet balance
                    $wallet->increment('balance', $payment->amount);
                    
                    // Record wallet transaction
                    $wallet->transactions()->create([
                        'type' => 'deposit',
                        'amount' => $payment->amount,
                        'description' => 'Wallet funding via Paystack',
                        'metadata' => [
                            'payment_id' => $payment->id,
                            'reference' => $payment->reference
                        ]
                    ]);

                    return redirect()->route('wallet.index')
                        ->with('success', 'Your wallet has been funded successfully!');
                });
            }
            
            // If payment not successful
            $payment->update([
                'status' => 'failed',
                'metadata' => array_merge(
                    $payment->metadata ?? [],
                    ['paystack_response' => $response->data, 'error' => 'Payment not successful']
                )
            ]);
            
            return redirect()->route('wallet.index')
                ->with('error', 'Payment was not successful. Please try again.');
                
        } catch (\Exception $e) {
            \Log::error('Payment Callback Error: ' . $e->getMessage());
            
            return redirect()->route('wallet.index')
                ->with('error', 'An error occurred while processing your payment. Please contact support.');
        }
    }

    /**
     * Transfer funds to another user's wallet
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transfer(Request $request)
    {
        $request->validate([
            'recipient_email' => 'required|email|exists:users,email',
            'amount' => 'required|numeric|min:100|max:1000000', // Minimum ₦100, Maximum ₦1,000,000
        ], [
            'amount.min' => 'The minimum transfer amount is ₦100.',
            'amount.max' => 'The maximum transfer amount is ₦1,000,000.',
            'recipient_email.exists' => 'No user found with this email address.',
        ]);

        $sender = Auth::user();
        $recipient = User::where('email', $request->recipient_email)->first();

        // Check if sender is trying to transfer to themselves
        if ($sender->id === $recipient->id) {
            return back()->with('error', 'You cannot transfer money to yourself.');
        }

        try {
            DB::beginTransaction();

            // Get or create sender's wallet with lock for update to prevent race conditions
            $senderWallet = $sender->wallet()->lockForUpdate()->firstOrCreate(
                ['user_id' => $sender->id],
                ['balance' => 0]
            );

            // Check if sender has sufficient balance
            if ($senderWallet->balance < $request->amount) {
                throw new \Exception('Insufficient funds. Your current balance is ₦' . number_format($senderWallet->balance, 2));
            }

            // Get or create recipient's wallet
            $recipientWallet = $recipient->wallet()->firstOrCreate(
                ['user_id' => $recipient->id],
                ['balance' => 0]
            );

            // Perform the transfer
            $senderWallet->decrement('balance', $request->amount);
            $recipientWallet->increment('balance', $request->amount);

            // Record the transaction for sender
            UserWalletTransaction::create([
                'user_wallet_id' => $senderWallet->id,
                'type' => 'transfer_out', // More specific transaction type
                'amount' => -$request->amount, // Negative amount for outgoing transfer
                'related_type' => User::class,
                'related_id' => $recipient->id,
                'status' => 'completed',
                'description' => 'Transfer to ' . $recipient->name,
                'metadata' => [
                    'recipient_email' => $recipient->email,
                    'reference' => 'TXN' . time() . $sender->id . $recipient->id,
                ]
            ]);

            // Record the transaction for recipient
            UserWalletTransaction::create([
                'user_wallet_id' => $recipientWallet->id,
                'type' => 'transfer_in', // More specific transaction type
                'amount' => $request->amount,
                'related_type' => User::class,
                'related_id' => $sender->id,
                'status' => 'completed',
                'description' => 'Transfer from ' . $sender->name,
                'metadata' => [
                    'sender_email' => $sender->email,
                    'reference' => 'TXN' . time() . $sender->id . $recipient->id,
                ]
            ]);

            DB::commit();
            return back()->with('success', 'Transfer of ₦' . number_format($request->amount, 2) . ' to ' . $recipient->name . ' was successful!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Transfer failed: ' . $e->getMessage());
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function payout(Request $request)
    {
        // This will be implemented later
    }
}
