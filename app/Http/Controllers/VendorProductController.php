<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class VendorProductController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;

        $products = $vendor->products()->with('images')->latest()->paginate(10);

        $stats = [
            'total' => $vendor->products()->count(),
            'published' => $vendor->products()->where('status', 'published')->count(),
            'draft' => $vendor->products()->where('status', 'draft')->count(),
            'out_of_stock' => $vendor->products()->where('stock_quantity', 0)->count(),
        ];

        return view('vendors.products.index', compact('products', 'stats'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('vendors.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max per file
        ]);

        // Create the product
        $product = auth()->user()->vendor->products()->create($validated);

        // Handle file uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/' . $product->id, 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product created successfully!');
    }

}