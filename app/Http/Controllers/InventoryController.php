<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $vendor = auth()->user()->vendor;
        $query = $vendor->products();

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('stock_quantity', '>', 0);
                    break;
                case 'low_stock':
                    $query->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 10);
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', 0);
                    break;
            }
        }

        $products = $query->latest()->paginate(15);

        $stats = [
            'total_products' => $vendor->products()->count(),
            'in_stock' => $vendor->products()->where('stock_quantity', '>', 0)->count(),
            'low_stock' => $vendor->products()->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 10)->count(),
            'out_of_stock' => $vendor->products()->where('stock_quantity', 0)->count(),
        ];

        return view('vendors.inventory.index', compact('products', 'stats'));
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate(['stock_quantity' => 'required|integer|min:0']);

        if ($product->vendor_id !== auth()->user()->vendor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $product->update(['stock_quantity' => $request->stock_quantity]);

        return response()->json(['success' => 'Stock updated successfully.']);
    }
    //
}
