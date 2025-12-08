<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WishlistController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\VendorProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SettingsController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/vendors', [VendorController::class, 'index'])->name('vendors.index');
// Vendor Registration Routes
Route::get('/vendors/register', [VendorController::class, 'register'])->name('vendors.register');
Route::post('/vendors/register', [VendorController::class, 'store'])->name('vendors.register.store');
Route::get('/vendors/{vendor:slug}', [VendorController::class, 'show'])->name('vendors.show');
Route::get('/about', [PageController::class, 'about'])->name('about');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::get('/orders', [\App\Http\Controllers\AdminController::class, 'orders'])->name('orders');
    Route::get('/products', [\App\Http\Controllers\AdminController::class, 'products'])->name('products');
    Route::get('/payments', [\App\Http\Controllers\AdminController::class, 'payments'])->name('payments');
    Route::get('/reports', [\App\Http\Controllers\AdminController::class, 'reports'])->name('reports');
    Route::get('/settings', [\App\Http\Controllers\AdminController::class, 'settings'])->name('settings');
    // Add other admin routes here
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // User Wallet Routes
    Route::prefix('wallet')->name('wallet.')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserWalletController::class, 'index'])->name('index');
        Route::get('/fund', [\App\Http\Controllers\UserWalletController::class, 'showFundForm'])->name('fund.show');
        
        // Paystack Integration
        Route::post('/fund/initialize', [\App\Http\Controllers\UserWalletController::class, 'initializePayment'])
            ->name('fund.initialize');
        Route::get('/fund/callback', [\App\Http\Controllers\UserWalletController::class, 'handleCallback'])
            ->name('fund.callback');
            
        Route::post('/transfer', [\App\Http\Controllers\UserWalletController::class, 'transfer'])->name('transfer');
        Route::post('/payout', [\App\Http\Controllers\UserWalletController::class, 'payout'])->name('payout');
    });

    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Addresses
    Route::resource('addresses', \App\Http\Controllers\AddressController::class)->except(['show']);
    
    // Shopping
    Route::resource('cart', CartController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('wishlist', WishlistController::class)->only(['index', 'store', 'destroy']);
    
    // Orders
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Checkout
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    
    // Payment
    Route::get('payment/{order}/pay', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('payment/{order}/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    
    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Payment Routes
    Route::get('/payment/paystack/{order}', [PaymentController::class, 'paystack'])->name('payment.paystack');
    Route::get('/payment/paystack/{order}/callback', [PaymentController::class, 'paystackCallback'])->name('payment.paystack.callback');
    Route::get('/payment/paystack/{order}/cancel', [PaymentController::class, 'paystackCancel'])->name('payment.paystack.cancel');
    Route::post('/payment/{order}/verify', [PaymentController::class, 'verifyPayment'])->name('payment.verify');
    
    // Vendor Routes
    Route::post('/vendors', [VendorController::class, 'store'])->name('vendors.store');

    // Vendor Routes
    Route::prefix('vendor')->name('vendor.')->middleware(['auth'])->group(function () {
        Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
        Route::get('/products', [VendorProductController::class, 'index'])->name('products.index');
        
        // Vendor Order Routes
        Route::get('/orders', [\App\Http\Controllers\VendorOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\VendorOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [\App\Http\Controllers\VendorOrderController::class, 'updateStatus'])->name('orders.update-status');
        
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
        Route::post('/inventory/{product}/stock', [InventoryController::class, 'updateStock'])->name('inventory.stock.update');
        Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
        Route::get('/wallet/payouts', [WalletController::class, 'payoutHistory'])->name('wallet.payout.history');
        Route::get('/wallet/payouts/request', [WalletController::class, 'requestPayout'])->name('wallet.payout.request');
        Route::post('/wallet/payouts/request', [WalletController::class, 'storePayoutRequest'])->name('wallet.payout.store');
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        
        // Settings routes
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::put('/profile', [SettingsController::class, 'updateProfile'])->name('profile.update');
            Route::put('/store', [SettingsController::class, 'updateStore'])->name('store.update');
            Route::put('/payments', [SettingsController::class, 'updatePaymentSettings'])->name('payments.update');
        });
        
        Route::get('/reviews', [VendorController::class, 'reviews'])->name('reviews');
    });
        
    // Add this inside your vendor route group
    Route::prefix('vendor')->name('vendor.')->middleware(['auth', 'verified'])->group(function () {
        // ... existing vendor routes ...
        
        // Products routes
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/create', [VendorProductController::class, 'create'])->name('create');
            Route::post('/', [VendorProductController::class, 'store'])->name('store');
            // Add other product routes as needed
        });
    
        // ... rest of your vendor routes ...
    });
    // Product Review Routes
    Route::post('/products/{product}/reviews', [ProductController::class, 'addReview'])->name('products.reviews.store');
    
    // Cart API Routes
    Route::get('/api/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
    
    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

require __DIR__.'/auth.php';
