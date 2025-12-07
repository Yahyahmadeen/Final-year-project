import { Head, Link, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    ShoppingCartIcon,
    TrashIcon,
    PlusIcon,
    MinusIcon,
    ArrowRightIcon,
    HeartIcon
} from '@heroicons/react/24/outline';
import { useState } from 'react';

export default function CartIndex({ cartItems = [], summary = {} }) {
    const [quantities, setQuantities] = useState(
        cartItems.reduce((acc, item) => ({
            ...acc,
            [item.id]: item.quantity
        }), {})
    );

    const updateQuantity = (itemId, newQuantity) => {
        if (newQuantity >= 1 && newQuantity <= 10) {
            setQuantities(prev => ({
                ...prev,
                [itemId]: newQuantity
            }));
            
            // Update cart via API
            router.patch(`/cart/${itemId}`, {
                quantity: newQuantity
            }, {
                preserveScroll: true
            });
        }
    };

    const removeItem = (itemId) => {
        router.delete(`/cart/${itemId}`, {
            preserveScroll: true
        });
    };

    const moveToWishlist = (itemId) => {
        router.post(`/wishlist/${itemId}`, {}, {
            preserveScroll: true
        });
    };

    return (
        <AppLayout>
            <Head title="Shopping Cart - eProShop" />
            
            <div className="min-h-screen bg-gray-50 py-8">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-secondary-800 mb-2">Shopping Cart</h1>
                        <p className="text-gray-600">
                            {cartItems.length > 0 
                                ? `${cartItems.length} item${cartItems.length !== 1 ? 's' : ''} in your cart`
                                : 'Your cart is empty'
                            }
                        </p>
                    </div>

                    {cartItems.length > 0 ? (
                        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            {/* Cart Items */}
                            <div className="lg:col-span-2 space-y-4">
                                {cartItems.map((item) => (
                                    <div key={item.id} className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                        <div className="flex items-start space-x-4">
                                            {/* Product Image */}
                                            <div className="w-24 h-24 bg-gray-200 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <ShoppingCartIcon className="h-8 w-8 text-gray-400" />
                                            </div>

                                            {/* Product Details */}
                                            <div className="flex-1 min-w-0">
                                                <div className="flex items-start justify-between">
                                                    <div>
                                                        <h3 className="text-lg font-semibold text-secondary-800 mb-1">
                                                            <Link 
                                                                href={`/products/${item.product.slug}`}
                                                                className="hover:text-primary-600 transition-colors"
                                                            >
                                                                {item.product.name}
                                                            </Link>
                                                        </h3>
                                                        <p className="text-sm text-primary-600 mb-2">
                                                            {item.product.vendor.store_name}
                                                        </p>
                                                        <div className="flex items-center space-x-4">
                                                            <span className="text-xl font-bold text-secondary-800">
                                                                ₦{(item.product.sale_price || item.product.price).toLocaleString()}
                                                            </span>
                                                            {item.product.sale_price && (
                                                                <span className="text-sm text-gray-500 line-through">
                                                                    ₦{item.product.price.toLocaleString()}
                                                                </span>
                                                            )}
                                                        </div>
                                                    </div>

                                                    {/* Actions */}
                                                    <div className="flex items-center space-x-2">
                                                        <button
                                                            onClick={() => moveToWishlist(item.id)}
                                                            className="p-2 text-gray-400 hover:text-red-500 transition-colors"
                                                            title="Move to Wishlist"
                                                        >
                                                            <HeartIcon className="h-5 w-5" />
                                                        </button>
                                                        <button
                                                            onClick={() => removeItem(item.id)}
                                                            className="p-2 text-gray-400 hover:text-red-500 transition-colors"
                                                            title="Remove from Cart"
                                                        >
                                                            <TrashIcon className="h-5 w-5" />
                                                        </button>
                                                    </div>
                                                </div>

                                                {/* Quantity Controls */}
                                                <div className="flex items-center justify-between mt-4">
                                                    <div className="flex items-center space-x-3">
                                                        <span className="text-sm text-gray-600">Quantity:</span>
                                                        <div className="flex items-center space-x-2">
                                                            <button
                                                                onClick={() => updateQuantity(item.id, quantities[item.id] - 1)}
                                                                disabled={quantities[item.id] <= 1}
                                                                className="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-full transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                                            >
                                                                <MinusIcon className="h-4 w-4" />
                                                            </button>
                                                            <span className="text-lg font-semibold min-w-[2rem] text-center">
                                                                {quantities[item.id]}
                                                            </span>
                                                            <button
                                                                onClick={() => updateQuantity(item.id, quantities[item.id] + 1)}
                                                                disabled={quantities[item.id] >= 10}
                                                                className="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-full transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                                            >
                                                                <PlusIcon className="h-4 w-4" />
                                                            </button>
                                                        </div>
                                                    </div>

                                                    {/* Item Total */}
                                                    <div className="text-right">
                                                        <div className="text-lg font-bold text-secondary-800">
                                                            ₦{((item.product.sale_price || item.product.price) * quantities[item.id]).toLocaleString()}
                                                        </div>
                                                        <div className="text-sm text-gray-500">
                                                            ₦{(item.product.sale_price || item.product.price).toLocaleString()} each
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>

                            {/* Order Summary */}
                            <div className="lg:col-span-1">
                                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-8">
                                    <h2 className="text-xl font-bold text-secondary-800 mb-6">Order Summary</h2>
                                    
                                    <div className="space-y-4 mb-6">
                                        <div className="flex justify-between text-gray-600">
                                            <span>Subtotal ({summary.itemCount || cartItems.length} items)</span>
                                            <span>₦{(summary.subtotal || 0).toLocaleString()}</span>
                                        </div>
                                        <div className="flex justify-between text-gray-600">
                                            <span>Shipping</span>
                                            <span className={summary.shipping === 0 ? "text-green-600" : "text-gray-600"}>
                                                {summary.shipping === 0 ? 'Free' : `₦${summary.shipping?.toLocaleString() || 0}`}
                                            </span>
                                        </div>
                                        <div className="flex justify-between text-gray-600">
                                            <span>Tax (7.5% VAT)</span>
                                            <span>₦{(summary.tax || 0).toLocaleString()}</span>
                                        </div>
                                        <hr className="border-gray-200" />
                                        <div className="flex justify-between text-lg font-bold text-secondary-800">
                                            <span>Total</span>
                                            <span>₦{(summary.total || 0).toLocaleString()}</span>
                                        </div>
                                    </div>

                                    {/* Checkout Button */}
                                    <Link
                                        href="/checkout"
                                        className="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-4 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300 flex items-center justify-center space-x-2 mb-4"
                                    >
                                        <span>Proceed to Checkout</span>
                                        <ArrowRightIcon className="h-5 w-5" />
                                    </Link>

                                    {/* Continue Shopping */}
                                    <Link
                                        href="/shop"
                                        className="w-full block text-center bg-gray-100 text-gray-700 py-3 px-4 rounded-2xl font-semibold hover:bg-gray-200 transition-colors"
                                    >
                                        Continue Shopping
                                    </Link>

                                    {/* Security Badge */}
                                    <div className="mt-6 p-4 bg-green-50 rounded-xl">
                                        <div className="flex items-center space-x-2 text-green-800">
                                            <div className="w-2 h-2 bg-green-500 rounded-full"></div>
                                            <span className="text-sm font-medium">Secure Checkout</span>
                                        </div>
                                        <p className="text-xs text-green-700 mt-1">
                                            Your payment information is protected with 256-bit SSL encryption
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ) : (
                        /* Empty Cart */
                        <div className="text-center py-16">
                            <div className="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 max-w-md mx-auto">
                                <ShoppingCartIcon className="h-24 w-24 text-gray-300 mx-auto mb-6" />
                                <h2 className="text-2xl font-bold text-secondary-800 mb-4">Your cart is empty</h2>
                                <p className="text-gray-600 mb-8">
                                    Looks like you haven't added any items to your cart yet. Start shopping to fill it up!
                                </p>
                                <Link
                                    href="/shop"
                                    className="inline-flex items-center space-x-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-6 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300"
                                >
                                    <span>Start Shopping</span>
                                    <ArrowRightIcon className="h-5 w-5" />
                                </Link>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
