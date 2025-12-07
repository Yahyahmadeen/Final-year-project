<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::with(['vendor', 'category'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->limit(6)
            ->get()
            ->map(function($product) {
                // Convert images JSON to collection for easier handling in the view
                $product->images = $product->images ? json_decode($product->images) : [];
                return $product;
            });

        $categories = Category::withCount(['products' => function($query) {
                $query->where('status', 'published');
            }])
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        $featuredVendors = Vendor::with('user')
            ->where('status', 'approved')
            ->where('is_featured', true)
            ->limit(4)
            ->get();

        return view('home', [
            'featuredProducts' => $featuredProducts,
            'categories' => $categories,
            'vendors' => $featuredVendors,
        ]);
    }
}
