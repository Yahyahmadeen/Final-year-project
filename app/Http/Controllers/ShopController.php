<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['vendor', 'category'])
            ->where('status', 'published');

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('short_description', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Vendor filter
        if ($request->filled('vendor')) {
            $query->whereHas('vendor', function ($q) use ($request) {
                $q->where('slug', $request->vendor);
            });
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc');
                break;
            case 'popular':
                $query->orderBy('sales_count', 'desc');
                break;
            default:
                $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount('products')
            ->get();

        $vendors = Vendor::where('status', 'approved')
            ->withCount('products')
            ->get();

        return view('shop.index', [
            'products' => $products,
            'categories' => $categories,
            'vendors' => $vendors,
            'filters' => $request->only(['search', 'category', 'vendor', 'min_price', 'max_price', 'sort', 'order']),
        ]);
    }
}
