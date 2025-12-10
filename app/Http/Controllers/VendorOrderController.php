<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorOrderController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Auth::user()->vendor;
        
        // Get orders that contain vendor's products
        $query = Order::whereHas('items', function($q) use ($vendor) {
            $q->whereHas('product', function($pq) use ($vendor) {
                $pq->where('vendor_id', $vendor->id);
            });
        })->with(['user', 'items.product']);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment')) {
            $query->where('payment_status', $request->payment);
        }

        $orders = $query->latest()->paginate(15);

        // Calculate stats
        $allOrders = Order::whereHas('items', function($q) use ($vendor) {
            $q->whereHas('product', function($pq) use ($vendor) {
                $pq->where('vendor_id', $vendor->id);
            });
        });

        $stats = [
            'total' => $allOrders->count(),
            'pending' => $allOrders->clone()->where('status', 'pending')->count(),
            'processing' => $allOrders->clone()->where('status', 'processing')->count(),
            'shipped' => $allOrders->clone()->where('status', 'shipped')->count(),
            'delivered' => $allOrders->clone()->where('status', 'delivered')->count(),
        ];

        return view('vendors.orders.index', compact('orders', 'stats'));
    }

    public function show($id)
    {
        $vendor = Auth::user()->vendor;
        
        $order = Order::with(['user', 'items.product.images'])
            ->whereHas('items', function($q) use ($vendor) {
                $q->whereHas('product', function($pq) use ($vendor) {
                    $pq->where('vendor_id', $vendor->id);
                });
            })
            ->findOrFail($id);

        // Filter order items to show only vendor's products
        $vendorItems = $order->items->filter(function($item) use ($vendor) {
            return $item->product && $item->product->vendor_id == $vendor->id;
        });

        return view('vendors.orders.show', compact('order', 'vendorItems'));
    }

    public function updateStatus(Request $request, $id)
    {
        $vendor = Auth::user()->vendor;
        
        $order = Order::whereHas('items', function($q) use ($vendor) {
            $q->whereHas('product', function($pq) use ($vendor) {
                $pq->where('vendor_id', $vendor->id);
            });
        })->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}
