<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function orders()
    {
        $orders = \App\Models\Order::with('user')->latest()->paginate(15);
        return view('admin.orders', compact('orders'));
    }

    public function products()
    {
        $products = \App\Models\Product::with('vendor')->latest()->paginate(15);
        return view('admin.products', compact('products'));
    }

    public function payments()
    {
        $payments = WalletTransaction::with(['order', 'vendor'])->latest()->paginate(15);
        return view('admin.payments', compact('payments'));
    }

    public function reports(Request $request)
    {
        $reportType = $request->input('report_type', 'sales');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $reportData = null;

        if ($startDate && $endDate) {
            switch ($reportType) {
                case 'sales':
                    $orders = \App\Models\Order::whereBetween('created_at', [$startDate, $endDate])->get();
                    $reportData = [
                        'total_revenue' => $orders->sum('total_amount'),
                        'total_orders' => $orders->count(),
                        'average_order_value' => $orders->avg('total_amount'),
                        'orders' => $orders,
                    ];
                    break;
                case 'users':
                    $users = User::whereBetween('created_at', [$startDate, $endDate])->get();
                    $reportData = [
                        'total_users' => $users->count(),
                        'users' => $users,
                    ];
                    break;
                case 'products':
                    $products = \App\Models\Product::with('orderItems')
                        ->whereHas('orderItems', function ($query) use ($startDate, $endDate) {
                            $query->whereHas('order', function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('created_at', [$startDate, $endDate]);
                            });
                        })
                        ->get()
                        ->map(function ($product) {
                            $product->units_sold = $product->orderItems->sum('quantity');
                            $product->revenue = $product->orderItems->sum(function ($item) {
                                return $item->quantity * $item->price;
                            });
                            return $product;
                        });

                    $reportData = [
                        'total_products_sold' => $products->sum('units_sold'),
                        'total_revenue' => $products->sum('revenue'),
                        'products' => $products,
                    ];
                    break;
            }
        }

        return view('admin.reports', compact('reportType', 'reportData'));
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
