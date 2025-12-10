<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product', 'vendor'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product', 'vendor']);

        return view('orders.show', [
            'order' => $order,
            'trackingSteps' => $this->getTrackingSteps($order)
        ]);
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'shipping_address' => 'required|array',
            'payment_method' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'status' => 'pending',
            'total_amount' => $validated['total_amount'],
            'shipping_address' => $validated['shipping_address'],
            'payment_method' => $validated['payment_method'],
        ]);

        // Create order items
        foreach ($validated['items'] as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ]);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Track an order by order number (public access).
     */
    public function track(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'order_number' => 'required|string'
            ]);

            $order = Order::where('order_number', $validated['order_number'])
                ->with(['items.product', 'vendor', 'user'])
                ->first();

            if (!$order) {
                return back()->withErrors(['order_number' => 'Order not found. Please check your order number and try again.']);
            }

            return view('orders.track-result', [
                'order' => $order,
                'trackingSteps' => $this->getTrackingSteps($order)
            ]);
        }

        return view('orders.track');
    }

    /**
     * Get tracking steps for order progress.
     */
    private function getTrackingSteps(Order $order)
    {
        $steps = [
            [
                'status' => 'pending',
                'title' => 'Order Placed',
                'description' => 'Your order has been received and is being processed',
                'icon' => 'shopping-cart',
                'completed' => true,
                'date' => $order->created_at
            ],
            [
                'status' => 'processing',
                'title' => 'Payment Confirmed',
                'description' => 'Payment has been confirmed and order is being prepared',
                'icon' => 'credit-card',
                'completed' => $order->isPaid() && in_array($order->status, ['processing', 'shipped', 'delivered']),
                'date' => $order->isPaid() ? ($order->updated_at ?? null) : null
            ],
            [
                'status' => 'shipped',
                'title' => 'Order Shipped',
                'description' => 'Your order has been shipped and is on its way',
                'icon' => 'truck',
                'completed' => in_array($order->status, ['shipped', 'delivered']),
                'date' => $order->shipped_at
            ],
            [
                'status' => 'delivered',
                'title' => 'Order Delivered',
                'description' => 'Your order has been successfully delivered',
                'icon' => 'check-circle',
                'completed' => $order->status === 'delivered',
                'date' => $order->delivered_at
            ]
        ];

        // Handle cancelled orders
        if ($order->status === 'cancelled') {
            $steps[] = [
                'status' => 'cancelled',
                'title' => 'Order Cancelled',
                'description' => 'This order has been cancelled',
                'icon' => 'x-circle',
                'completed' => true,
                'date' => $order->updated_at,
                'is_cancelled' => true
            ];
        }

        return $steps;
    }

    /**
     * Cancel an order.
     */
    public function cancel(Order $order)
    {
        // Ensure user can only cancel their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow cancellation of pending orders
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled successfully!');
    }
}
