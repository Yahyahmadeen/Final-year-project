<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->where('is_active', true);
            }])
            ->withCount(['products' => function ($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('sort_order')
            ->get();

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    public function show(Category $category, Request $request)
    {
        // Get products in this category
        $query = Product::with(['vendor', 'category', 'images'])
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->withCount('reviews');

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
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
        $sortBy = $request->get('sort', 'newest');
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
            case 'newest':
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        // Get subcategories
        $subcategories = Category::where('parent_id', $category->id)
            ->where('is_active', true)
            ->withCount(['products' => function ($query) {
                $query->where('status', 'published');
            }])
            ->get();

        return view('categories.show', [
            'category' => $category->load('parent'),
            'products' => $products,
            'subcategories' => $subcategories,
        ]);
    }
}
