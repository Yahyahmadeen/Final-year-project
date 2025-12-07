<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $data = [
            'user' => $user,
            'totalOrders' => $user->orders()->count(),
            'pendingOrders' => $user->orders()->whereIn('status', ['pending', 'processing'])->count(),
            'recentOrders' => $user->orders()->with(['items.product'])->latest()->take(3)->get(),
            'wishlistCount' => $user->wishlist()->count(),
            'recentlyViewed' => $user->recentlyViewedProducts()->take(3)->get()
        ];

        $recentOrders = Auth::user()->orders()->latest()->take(5)->get();
        $walletBalance = Auth::user()->wallet->balance ?? 0;

        return view('dashboard', array_merge($data, compact('recentOrders', 'walletBalance')));
    }
}
