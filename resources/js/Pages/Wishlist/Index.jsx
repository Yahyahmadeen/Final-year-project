import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    HeartIcon,
    ShoppingCartIcon,
    TrashIcon
} from '@heroicons/react/24/outline';
import { HeartIcon as HeartSolidIcon } from '@heroicons/react/24/solid';

export default function WishlistIndex({ wishlistItems }) {
    return (
        <AppLayout>
            <Head title="My Wishlist - eProShop" />
            
            <div className="min-h-screen bg-gray-50">
                {/* Header */}
                <div className="bg-white shadow-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-3xl font-bold text-secondary-800 flex items-center">
                                    <HeartSolidIcon className="h-8 w-8 text-red-500 mr-3" />
                                    My Wishlist
                                </h1>
                                <p className="text-gray-600 mt-2">
                                    {wishlistItems.length} items saved for later
                                </p>
                            </div>
                            <Link 
                                href="/shop" 
                                className="bg-primary-500 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-primary-600 transition-colors"
                            >
                                Continue Shopping
                            </Link>
                        </div>
                    </div>
                </div>

                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {wishlistItems.length > 0 ? (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            {wishlistItems.map((item) => (
                                <div key={item.id} className="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-all duration-300">
                                    <div className="relative">
                                        <div className="aspect-square bg-gray-200 flex items-center justify-center">
                                            <ShoppingCartIcon className="h-16 w-16 text-gray-400" />
                                        </div>
                                        <div className="absolute top-4 right-4 flex space-x-2">
                                            <button className="bg-white p-2 rounded-full shadow-lg hover:bg-gray-50 text-red-500">
                                                <TrashIcon className="h-5 w-5" />
                                            </button>
                                        </div>
                                        {item.product?.sale_price && (
                                            <div className="absolute top-4 left-4 bg-red-500 text-white px-2 py-1 rounded-lg text-sm font-semibold">
                                                {Math.round(((item.product.price - item.product.sale_price) / item.product.price) * 100)}% OFF
                                            </div>
                                        )}
                                    </div>
                                    <div className="p-4">
                                        <div className="text-sm text-primary-600 mb-1">{item.product?.vendor?.store_name}</div>
                                        <Link 
                                            href={`/products/${item.product?.slug}`}
                                            className="block"
                                        >
                                            <h3 className="text-lg font-semibold text-secondary-800 mb-2 line-clamp-2 hover:text-primary-600">
                                                {item.product?.name}
                                            </h3>
                                        </Link>
                                        <div className="flex items-center justify-between mb-4">
                                            <div className="flex items-center space-x-2">
                                                <span className="text-xl font-bold text-secondary-800">
                                                    ₦{(item.product?.sale_price || item.product?.price)?.toLocaleString()}
                                                </span>
                                                {item.product?.sale_price && (
                                                    <span className="text-sm text-gray-500 line-through">
                                                        ₦{item.product?.price?.toLocaleString()}
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                        <button className="w-full bg-primary-500 text-white py-2 rounded-xl hover:bg-primary-600 transition-colors flex items-center justify-center space-x-2">
                                            <ShoppingCartIcon className="h-5 w-5" />
                                            <span>Add to Cart</span>
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="text-center py-16">
                            <div className="bg-gray-100 w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-6">
                                <HeartIcon className="h-16 w-16 text-gray-400" />
                            </div>
                            <h3 className="text-2xl font-semibold text-gray-600 mb-4">Your wishlist is empty</h3>
                            <p className="text-gray-500 mb-8 max-w-md mx-auto">
                                Save items you love by clicking the heart icon on any product. 
                                They'll appear here for easy access later.
                            </p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Link 
                                    href="/shop" 
                                    className="bg-primary-500 text-white px-8 py-4 rounded-2xl font-semibold hover:bg-primary-600 transition-colors"
                                >
                                    Discover Products
                                </Link>
                                <Link 
                                    href="/categories" 
                                    className="border-2 border-primary-500 text-primary-500 px-8 py-4 rounded-2xl font-semibold hover:bg-primary-500 hover:text-white transition-colors"
                                >
                                    Browse Categories
                                </Link>
                            </div>
                        </div>
                    )}
                </div>

                {/* Recommendations Section */}
                <div className="bg-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                        <div className="text-center mb-12">
                            <h2 className="text-3xl font-bold text-secondary-800 mb-4">You Might Also Like</h2>
                            <p className="text-gray-600">Discover more products from our featured collection</p>
                        </div>
                        
                        <div className="text-center">
                            <Link 
                                href="/shop?featured=1" 
                                className="bg-primary-500 text-white px-8 py-4 rounded-2xl font-semibold hover:bg-primary-600 transition-colors inline-block"
                            >
                                View Featured Products
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
