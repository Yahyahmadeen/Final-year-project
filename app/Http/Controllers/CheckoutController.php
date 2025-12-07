<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserWallet;
use App\Models\VendorWallet;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index(Request $request)
    {
        $cartItems = CartItem::where('user_id', auth()->id())
            ->with(['product', 'product.vendor'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Add items to proceed to checkout.');
        }

        // Group cart items by vendor
        $groupedItems = $cartItems->groupBy('product.vendor_id');
        
        // Calculate totals per vendor
        $vendorTotals = [];
        $subtotal = 0;
        
        foreach ($groupedItems as $vendorId => $items) {
            $vendorSubtotal = $items->sum(function ($item) {
                if (!$item->product) {
                    return 0;
                }
                return $item->quantity * ($item->product->sale_price ?? $item->product->price);
            });
            
            // Calculate shipping per vendor (you can customize this logic)
            $vendorShipping = 500; // Example: ₦500 per vendor
            $vendorTax = $vendorSubtotal * 0.075; // 7.5% VAT
            $vendorTotal = $vendorSubtotal + $vendorShipping + $vendorTax;
            
            $vendorTotals[$vendorId] = [
                'subtotal' => $vendorSubtotal,
                'shipping' => $vendorShipping,
                'tax' => $vendorTax,
                'total' => $vendorTotal,
                'items' => $items
            ];
            
            $subtotal += $vendorSubtotal;
        }
        
        // Calculate overall totals
        $shippingFee = 2000; // Base shipping fee
        $taxRate = 0.075; // 7.5% VAT
        $taxAmount = $subtotal * $taxRate;
        $total = $subtotal + $shippingFee + $taxAmount;
        
        // Get user's wallet balance
        $wallet = UserWallet::firstOrCreate(
            ['user_id' => auth()->id()],
            ['balance' => 0]
        );
        $walletBalance = $wallet->balance;

        return view('checkout.index', [
            'cartItems' => $cartItems,
            'groupedItems' => $groupedItems,
            'vendorTotals' => $vendorTotals,
            'walletBalance' => $walletBalance,
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => $shippingFee,
                'tax' => $taxAmount,
                'total' => $total,
            ],
            'user' => auth()->user(),
        ]);
    }

    /**
     * Process the checkout and create order.
     */
    /**
     * Process the checkout and create orders for multiple vendors.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'shipping_address' => 'required|array',
                'shipping_address.name' => 'required|string|max:255',
                'shipping_address.phone' => 'required|string|max:20',
                'shipping_address.address' => 'required|string|max:500',
                'shipping_address.city' => 'required|string|max:100',
                'shipping_address.state' => 'required|string|max:100',
                'shipping_address.postal_code' => 'nullable|string|max:10',
                'payment_method' => 'required|in:wallet,paystack',
                'notes' => 'nullable|string|max:1000',
            ]);

            $user = auth()->user();
            $cartItems = CartItem::where('user_id', $user->id)
                ->with(['product', 'product.vendor'])
                ->get();

            if ($cartItems->isEmpty()) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Your cart is empty.'], 400);
                }
                return back()->with('error', 'Your cart is empty.');
            }

            // Group cart items by vendor
            $groupedItems = $cartItems->groupBy('product.vendor_id');
            
            // Calculate totals per vendor and overall
            $vendorTotals = [];
            $totalAmount = 0;
            $shippingFee = 0;
            
            foreach ($groupedItems as $vendorId => $items) {
                $vendorSubtotal = $items->sum(function ($item) {
                    if (!$item->product) {
                        return 0;
                    }
                    return $item->quantity * ($item->product->sale_price ?? $item->product->price);
                });
                
                $vendorShipping = 500; // Per vendor shipping
                $vendorTax = $vendorSubtotal * 0.075; // 7.5% VAT
                $vendorTotal = $vendorSubtotal + $vendorShipping + $vendorTax;
                
                $vendorTotals[$vendorId] = [
                    'subtotal' => $vendorSubtotal,
                    'shipping' => $vendorShipping,
                    'tax' => $vendorTax,
                    'total' => $vendorTotal,
                    'items' => $items
                ];
                
                $totalAmount += $vendorTotal;
                $shippingFee += $vendorShipping;
            }

            // Start database transaction
            DB::beginTransaction();

            // Check wallet balance for wallet payment
            if ($validated['payment_method'] === 'wallet') {
                $wallet = UserWallet::firstOrCreate(
                    ['user_id' => $user->id],
                    ['balance' => 0]
                );

                if ($wallet->balance < $totalAmount) {
                    DB::rollBack();
                    $shortfall = $totalAmount - $wallet->balance;
                    if ($request->ajax()) {
                        return response()->json(['error' => 'Insufficient wallet balance. You need ₦' . number_format($shortfall, 2) . ' more.'], 400);
                    }
                    return back()->with('error', 'Insufficient wallet balance. You need ₦' . number_format($shortfall, 2) . ' more.');
                }

                // Deduct from wallet
                $wallet->decrement('balance', $totalAmount);

                // Record wallet transaction
                $wallet->transactions()->create([
                    'amount' => $totalAmount,
                    'type' => 'debit',
                    'description' => 'Payment for order',
                    'status' => 'completed',
                    'reference' => 'WALLET-' . time() . '-' . $user->id,
                ]);
            }

            $orders = [];
            
            // Create orders for each vendor
            foreach ($vendorTotals as $vendorId => $vendorData) {
                $vendor = $vendorId ? Vendor::find($vendorId) : null;
                
                // Create order
                $order = Order::create([
                    'user_id' => $user->id,
                    'vendor_id' => $vendorId,
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'status' => $validated['payment_method'] === 'paystack' ? 'pending_payment' : 'processing',
                    'subtotal' => $vendorData['subtotal'],
                    'tax_amount' => $vendorData['tax'],
                    'shipping_amount' => $vendorData['shipping'],
                    'total_amount' => $vendorData['total'],
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => $validated['payment_method'] === 'paystack' ? 'pending' : 'paid',
                    'shipping_address' => $validated['shipping_address'],
                    'notes' => $validated['notes'] ?? null,
                ]);

                // Create order items
                foreach ($vendorData['items'] as $item) {
                    if (!$item->product) {
                        continue; // Skip if product is missing
                    }
                    
                    $price = $item->product->sale_price ?? $item->product->price;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'product_sku' => $item->product->sku,
                        'product_price' => $price,
                        'quantity' => $item->quantity,
                        'total_price' => $price * $item->quantity,
                    ]);
                    
                    // Update product stock
                    $item->product->decrement('stock_quantity', $item->quantity);
                }
                
                // If payment is by wallet, transfer to vendor's wallet immediately
                if ($validated['payment_method'] === 'wallet' && $vendor) {
                    $vendorWallet = VendorWallet::firstOrCreate(
                        ['vendor_id' => $vendor->id],
                        ['balance' => 0]
                    );
                    
                    // Calculate vendor's earnings (subtract platform fee if any)
                    $platformFee = $vendorData['total'] * 0.05; // 5% platform fee
                    $vendorEarnings = $vendorData['total'] - $platformFee;
                    
                    $vendorWallet->increment('balance', $vendorEarnings);
                    
                    // Record vendor wallet transaction
                    $vendorWallet->transactions()->create([
                        'amount' => $vendorEarnings,
                        'type' => 'credit',
                        'description' => 'Payment for order #' . $order->order_number,
                        'status' => 'completed',
                        'reference' => 'VENDOR-' . time() . '-' . $vendor->id,
                    ]);
                }
                
                $orders[] = $order;
            }

            // Clear cart
            CartItem::where('user_id', $user->id)->delete();

            // Commit transaction
            DB::commit();

            // Prepare success response
            $orderCount = count($orders);
            $successMessage = $orderCount > 1 
                ? "Orders placed successfully! {$orderCount} separate orders created for different vendors."
                : "Order placed successfully!";

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'redirect' => route('orders.index')
                ]);
            }

            return redirect()->route('orders.index')
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            
            Log::error('Checkout error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'An error occurred while processing your order. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }
}
