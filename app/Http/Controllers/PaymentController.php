<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /**
     * Display Paystack payment page
     */
    public function paystack(Order $order)
    {
        // Ensure user can only pay for their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if order is eligible for payment
        if ($order->status !== 'pending' || $order->payment_status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'This order is not eligible for payment.');
        }

        // Paystack public key (should be in .env file)
        $paystackPublicKey = env('PAYSTACK_PUBLIC_KEY', 'pk_test_your_paystack_public_key');

        return view('payment.paystack', [
            'order' => $order,
            'paystackPublicKey' => $paystackPublicKey,
            'user' => auth()->user(),
        ]);
    }

    /**
     * Handle Paystack payment callback
     */
    public function paystackCallback(Request $request, Order $order)
    {
        $reference = $request->get('reference');
        
        if (!$reference) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Payment reference not found.');
        }

        // Verify payment with Paystack API using Laravel HTTP client
        $paystackSecretKey = config('services.paystack.secret_key');
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $paystackSecretKey,
                'Cache-Control' => 'no-cache',
            ])
            ->timeout(30)
            ->get("https://api.paystack.co/transaction/verify/" . $reference);
            
            if (!$response->successful()) {
                return redirect()->route('orders.show', $order)
                    ->with('error', 'Payment verification failed. Please contact support.');
            }

            $result = $response->json();
            
            if (!$result['status'] || $result['data']['status'] !== 'success') {
                return redirect()->route('orders.show', $order)
                    ->with('error', 'Payment verification failed: ' . ($result['message'] ?? 'Unknown error'));
            }

            // Payment successful
            $order->update([
                'payment_status' => 'paid',
                'payment_reference' => $reference,
                'status' => 'processing',
                'paid_at' => now()
            ]);

            return redirect()->route('orders.show', $order)
                ->with('success', 'Payment successful! Your order is now being processed.');
        } catch(Exception $error) {
            // Payment failed
            return redirect()->route('orders.show', $order)
                ->with('error', 'Payment verification failed. Please try again or contact support.');
        }
    }

    /**
     * Handle payment cancellation
     */
    public function paystackCancel(Order $order)
    {
        return redirect()->route('orders.show', $order)
            ->with('info', 'Payment was cancelled. You can try again when ready.');
    }

    /**
     * Manually verify payment status
     */
    public function verifyPayment(Order $order)
    {
        // Ensure user can only verify their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$order->payment_reference) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'No payment reference found for this order.');
        }

        // Verify payment with Paystack API
        $paystackSecretKey = env('PAYSTACK_SECRET_KEY', 'sk_test_your_paystack_secret_key');
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . $order->payment_reference,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $paystackSecretKey,
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Payment verification failed. Please try again later.');
        }

        $result = json_decode($response, true);

        if ($result['status'] && $result['data']['status'] === 'success') {
            // Payment successful - update order
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing'
            ]);

            return redirect()->route('orders.show', $order)
                ->with('success', 'Payment verified successfully! Your order is now being processed.');
        } else {
            // Payment still pending or failed
            $paymentStatus = $result['data']['status'] ?? 'unknown';
            
            if ($paymentStatus === 'failed') {
                $order->update(['payment_status' => 'failed']);
                return redirect()->route('orders.show', $order)
                    ->with('error', 'Payment verification failed. The payment was not successful.');
            }

            return redirect()->route('orders.show', $order)
                ->with('info', 'Payment is still pending. Please wait a few minutes and try again.');
        }
    }
}
