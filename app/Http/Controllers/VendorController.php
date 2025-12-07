<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ProductReview;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    /**
     * Display a listing of the vendors.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $vendors = Vendor::query()
            ->where('status', 'approved')
            ->withCount(['products' => function($query) {
                $query->where('status', 'published');
            }])
            ->withAvg('reviews', 'rating')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('vendors.index', [
            'vendors' => $vendors,
        ]);
    }

    /**
     * Show the vendor registration form.
     *
     * @return \Illuminate\View\View
     */
    /**
     * Show the vendor registration form.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function register()
    {
        // If user is already logged in and is a vendor, redirect to vendor dashboard
        if (auth()->check() && auth()->user()->is_vendor) {
            return redirect()->route('vendor.dashboard');
        }

        return view('vendors.register');
    }

    /**
     * Store a new vendor application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * Store a newly created vendor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Define validation rules for all steps
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20'],
            'store_name' => ['nullable', 'string', 'max:255', Rule::unique('vendors', 'store_name')->where(function ($query) {
                return $query->where('store_name', '!=', '');
            })],
            'business_type' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:500'],
            'terms' => ['accepted'],
        ];

        // Validate the request data
        $validatedData = $request->validate($rules);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create new user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'vendor',
                'status' => 'pending',
            ]);

            // Log the user in
            Auth::login($user);

            // Create vendor record
            $vendor = new Vendor([
                'user_id' => $user->id,
                'store_name' => $validatedData['store_name'],
                'slug' => Str::slug($validatedData['store_name']),
                'business_type' => $validatedData['business_type'],
                'description' => $validatedData['description'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'address' => $validatedData['address'],
                'status' => 'pending', // Set initial status to pending
                'commission_rate' => 10.00, // Set a default commission rate
            ]);

            $vendor->save();

            // Commit the transaction
            DB::commit();

            // Redirect to vendor dashboard with success message
            return redirect()->route('vendor.dashboard')
                ->with('success', 'Your vendor account has been created successfully! It is pending approval.');

        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            // Log the error
            Log::error('Vendor registration error: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while processing your request. Please try again.');
        }
    }

   

    /**
     * Get validation rules for the current step.
     *
     * @param int $step
     * @return array
     */
   

    /**
     * Display the vendor dashboard.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function dashboard()
    {
        // Get the authenticated user
        $user = auth()->user();
        
        // Get the vendor associated with the user
        $vendor = $user->vendor;
        
        if (!$vendor) {
            return redirect()->route('home')->with('error', 'Vendor profile not found.');
        }
        
        // Initialize stats with default values
        $stats = [
            'total_orders' => 0,
            'total_revenue' => 0,
            'total_products' => 0,
            'total_customers' => 0,
        ];
        
        try {
            // Get vendor statistics
            $stats = [
                'total_orders' => \App\Models\Order::where('vendor_id', $vendor->id)->count() ?? 0,
                'total_revenue' => \App\Models\Order::where('vendor_id', $vendor->id)
                    ->where('status', 'completed')
                    ->sum('total_amount') ?? 0,
                'total_products' => \App\Models\Product::where('vendor_id', $vendor->id)->count() ?? 0,
                'total_customers' => \App\Models\Order::where('vendor_id', $vendor->id)
                    ->distinct('user_id')
                    ->count('user_id') ?? 0,
            ];
            
            // Get recent orders
            $recent_orders = \App\Models\Order::with(['user', 'items'])
                ->where('vendor_id', $vendor->id)
                ->latest()
                ->take(5)
                ->get() ?? collect();
            
            // Get recent products
            $recent_products = \App\Models\Product::where('vendor_id', $vendor->id)
                ->latest()
                ->take(5)
                ->get() ?? collect();
            
            // Get recent reviews
            $recent_reviews = \App\Models\ProductReview::whereHas('product', function($query) use ($vendor) {
                    $query->where('vendor_id', $vendor->id);
                })
                ->with(['user', 'product'])
                ->latest()
                ->take(5)
                ->get() ?? collect();

            // Get wallet balance
            $wallet_balance = \App\Models\WalletTransaction::where('vendor_id', $vendor->id)
                ->latest('id')
                ->value('balance_after') ?? 0;
            
            // Get recent transactions
            $recent_transactions = \App\Models\WalletTransaction::where('vendor_id', $vendor->id)
                ->latest()
                ->take(5)
                ->get() ?? collect();

            return view('vendors.dashboard', compact(
                'user',
                'vendor',
                'stats',
                'recentOrders',
                'recentProducts',
                'recentReviews',
                'walletBalance',
                'recentTransactions'
            ));

        } catch (\Exception $e) {
            // Log the error
            \Log::error('Dashboard Error: ' . $e->getMessage());
            
            // Return view with empty collections in case of error
            return view('vendors.dashboard', [
                'user' => $user,
                'vendor' => $vendor,
                'stats' => $stats,
                'recentOrders' => collect(),
                'recentProducts' => collect(),
                'recentReviews' => collect(),
                'walletBalance' => 0,
                'recentTransactions' => collect()
            ]);
        }
    }

    /**
     * Display all reviews for the authenticated vendor.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function reviews()
    {
        $user = auth()->user();
        $vendor = $user->vendor;
        if (!$vendor) {
            return redirect()->route('vendor.dashboard')->with('error', 'Vendor profile not found.');
        }

        $reviews = ProductReview::whereHas('product', function ($query) use ($vendor) {
                $query->where('vendor_id', $vendor->id);
            })
            ->with(['user', 'product'])
            ->latest()
            ->paginate(20);

        return view('vendors.reviews.index', compact('vendor', 'reviews'));
    }

    /**
     * Display the specified vendor.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $vendor = Vendor::where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        // Get filter parameters
        $search = request('search');
        $category = request('category');
        $minPrice = request('min_price');
        $maxPrice = request('max_price');
        $rating = request('rating');
        $sort = request('sort', 'newest');

        // Start building the products query
        $productsQuery = Product::query()
            ->where('vendor_id', $vendor->id)
            ->where('status', 'published')
            ->with(['category', 'reviews'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        // Apply search filter
        if ($search) {
            $productsQuery->where('name', 'like', "%{$search}%");
        }

        // Apply category filter
        if ($category) {
            $productsQuery->whereHas('category', function($query) use ($category) {
                $query->where('slug', $category);
            });
        }

        // Apply price range filter
        if ($minPrice) {
            $productsQuery->where('sale_price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $productsQuery->where(function($query) use ($maxPrice) {
                $query->where('sale_price', '<=', $maxPrice)
                    ->orWhere('price', '<=', $maxPrice);
            });
        }

        // Apply rating filter
        if ($rating) {
            $productsQuery->whereHas('reviews', function($query) use ($rating) {
                $query->select(DB::raw('AVG(rating) as avg_rating'))
                    ->groupBy('product_id')
                    ->havingRaw('AVG(rating) >= ?', [$rating]);
            });
        }

        // Apply sorting
        switch ($sort) {
            case 'price_low':
                $productsQuery->orderByRaw('IF(sale_price > 0, sale_price, price) ASC');
                break;
            case 'price_high':
                $productsQuery->orderByRaw('IF(sale_price > 0, sale_price, price) DESC');
                break;
            case 'rating':
                $productsQuery->orderBy('reviews_avg_rating', 'DESC');
                break;
            case 'popular':
                $productsQuery->orderBy('views', 'DESC');
                break;
            default: // 'newest'
                $productsQuery->latest();
                break;
        }

        // Get paginated products
        $products = $productsQuery->paginate(24);

        // Get categories for filter
        $categories = Category::whereHas('products', function($query) use ($vendor) {
                $query->where('vendor_id', $vendor->id);
            })
            ->orderBy('name')
            ->get();

        // Get wishlist items for authenticated user
        $wishlist = [];
        if (auth()->check()) {
            $wishlist = auth()->user()->wishlist()->pluck('product_id')->toArray();
        }

        return view('vendors.show', [
            'vendor' => $vendor,
            'products' => $products,
            'categories' => $categories,
            'wishlist' => $wishlist,
        ]);
    }

    /**
     * Show the vendor registration form.
     *
     * @return \Illuminate\View\View
     */
    // public function register()
    // {
    //     // Check if user already has a vendor account
    //     if (auth()->check() && auth()->user()->vendor) {
    //         return redirect()->route('dashboard')
    //             ->with('info', 'You already have a vendor account.');
    //     }

    //     // Get any previously entered data from the session
    //     $vendorData = session('vendor_data', [
    //         'store_name' => '',
    //         'business_type' => '',
    //         'description' => '',
    //         'phone' => '',
    //         'email' => '',
    //         'address' => '',
    //         'city' => '',
    //         'postal_code' => '',
    //         'business_registration_number' => '',
    //     ]);

    //     // Get the current step from the session or default to 1
    //     $currentStep = session('current_step', 1);

    //     return view('vendors.register', [
    //         'vendorData' => $vendorData,
    //         'currentStep' => $currentStep,
    //     ]);
    // }

    /**
        
        // Clear the session data
        $request->session()->forget(['vendor_data', 'current_step']);
        
        return redirect()->route('vendors.index')
            ->with('success', 'Your vendor application has been submitted successfully! We will review your application and notify you once approved.');
    //             return redirect()->route('dashboard')
    //                 ->with('error', 'You already have a vendor account.');
    //         }
            
    //         // Create the vendor
    //         $vendor = new Vendor([
    //             'user_id' => auth()->id(),
    //             'store_name' => $vendorData['store_name'],
    //             'slug' => Str::slug($vendorData['store_name']),
    //             'description' => $vendorData['description'],
    //             'business_type' => $vendorData['business_type'],
    //             'phone' => $vendorData['phone'],
    //             'email' => $vendorData['email'] ?? null,
    //             'address' => $vendorData['address'],
    //             'city' => $vendorData['city'] ?? null,
    //             'postal_code' => $vendorData['postal_code'] ?? null,
    //             'business_registration_number' => $vendorData['business_registration_number'] ?? null,
    //             'status' => 'pending',
    //         ]);
            
    //         // Save the vendor
    //         $vendor->save();
            
    //         // Update user role to vendor
    //         if (auth()->check()) {
    //             auth()->user()->update(['role' => 'vendor']);
    //         }
            
    //         // Clear the session data
    //         $request->session()->forget(['vendor_data', 'current_step']);
            
    //         return redirect()->route('vendors.index')
    //             ->with('success', 'Your vendor application has been submitted successfully! We will review your application and notify you once approved.');
    //     }
    // }
    
    /**
     * Get validation rules for the current step.
     *
     * @param  int  $step
     * @return array
     */
    
    /**
     * Handle contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\JsonResponse
     */
    public function contact(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ]);
        
        // Here you would typically send an email to the vendor
        // For now, we'll just return a success response
        
        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent to the vendor. They will contact you soon.',
        ]);
    }
}
