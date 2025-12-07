<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        // Get some stats for the about page
        $stats = [
            'total_products' => Product::where('status', 'published')->count(),
            'total_vendors' => Vendor::where('status', 'approved')->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_orders' => 0, // Will be implemented when Order model is complete
        ];

        return view('pages.about', compact('stats'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function privacy()
    {
        return Inertia::render('Pages/Privacy');
    }

    public function terms()
    {
        return Inertia::render('Pages/Terms');
    }
}
