<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $total_users = User::count();
        $total_orders = Order::count();
        $total_revenue = Order::where('status', 'delivered')->sum('total_amount');

        $recent_orders = Order::with('user')->latest()->take(5)->get();
        $recent_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'total_users',
            'total_orders',
            'total_revenue',
            'recent_orders',
            'recent_users'
        ));
    }
}
