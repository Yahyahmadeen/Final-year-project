import { Head, Link, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    ShoppingCartIcon,
    HeartIcon,
    StarIcon,
    ShareIcon,
    TruckIcon,
    ShieldCheckIcon,
    ArrowLeftIcon,
    PlusIcon,
    MinusIcon,
    EyeIcon,
    CheckCircleIcon
} from '@heroicons/react/24/outline';
import { HeartIcon as HeartSolidIcon } from '@heroicons/react/24/solid';
import { useState } from 'react';

export default function ProductShow({ product, relatedProducts = [], reviews = [], isInWishlist = false }) {
    const [quantity, setQuantity] = useState(1);
    const [selectedImage, setSelectedImage] = useState(0);
    const [activeTab, setActiveTab] = useState('description');
    const [isAddingToCart, setIsAddingToCart] = useState(false);
    const [isAddingToWishlist, setIsAddingToWishlist] = useState(false);

    const currentPrice = product.sale_price || product.price;
    const hasDiscount = product.sale_price && product.sale_price < product.price;
    const discountPercentage = hasDiscount ? Math.round(((product.price - product.sale_price) / product.price) * 100) : 0;

    const updateQuantity = (newQuantity) => {
        if (newQuantity >= 1 && newQuantity <= 10) {
            setQuantity(newQuantity);
        }
    };

    const addToCart = () => {
        setIsAddingToCart(true);
        router.post('/cart/add', {
            product_id: product.id,
            quantity: quantity
        }, {
            preserveScroll: true,
            onFinish: () => setIsAddingToCart(false)
        });
    };

    const toggleWishlist = () => {
        setIsAddingToWishlist(true);
        if (isInWishlist) {
            router.delete('/wishlist/remove', {
                data: { product_id: product.id }
            }, {
                preserveScroll: true,
                onFinish: () => setIsAddingToWishlist(false)
            });
        } else {
            router.post('/wishlist/add', {
                product_id: product.id
            }, {
                preserveScroll: true,
                onFinish: () => setIsAddingToWishlist(false)
            });
        }
    };

    const renderStars = (rating) => {
        return [...Array(5)].map((_, i) => (
            <StarIcon 
                key={i} 
                className={`h-5 w-5 ${i < Math.floor(rating) ? 'text-yellow-400 fill-current' : 'text-gray-300'}`} 
            />
        ));
    };

    return (
        <AppLayout>
            <Head title={`${product.name} - eProShop`} />
            
            <div className="min-h-screen bg-gray-50">
                {/* Breadcrumb */}
                <div className="bg-white border-b border-gray-200">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                        <nav className="flex items-center space-x-2 text-sm">
                            <Link href="/" className="text-gray-500 hover:text-primary-600">Home</Link>
                            <span className="text-gray-400">/</span>
                            <Link href="/shop" className="text-gray-500 hover:text-primary-600">Shop</Link>
                            <span className="text-gray-400">/</span>
                            <Link href={`/categories/${product.category.slug}`} className="text-gray-500 hover:text-primary-600">
                                {product.category.name}
                            </Link>
                            <span className="text-gray-400">/</span>
                            <span className="text-secondary-800 font-medium">{product.name}</span>
                        </nav>
                    </div>
                </div>

                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        {/* Product Images */}
                        <div className="space-y-4">
                            {/* Main Image */}
                            <div className="aspect-square bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center">
                                <ShoppingCartIcon className="h-32 w-32 text-gray-300" />
                            </div>
                            
                            {/* Thumbnail Images */}
                            <div className="grid grid-cols-4 gap-4">
                                {[...Array(4)].map((_, index) => (
                                    <button
                                        key={index}
                                        onClick={() => setSelectedImage(index)}
                                        className={`aspect-square bg-white rounded-xl border-2 flex items-center justify-center transition-colors ${
                                            selectedImage === index ? 'border-primary-500' : 'border-gray-200 hover:border-gray-300'
                                        }`}
                                    >
                                        <ShoppingCartIcon className="h-8 w-8 text-gray-300" />
                                    </button>
                                ))}
                            </div>
                        </div>

                        {/* Product Info */}
                        <div className="space-y-6">
                            {/* Back Button */}
                            <Link
                                href="/shop"
                                className="inline-flex items-center text-gray-600 hover:text-primary-600 transition-colors"
                            >
                                <ArrowLeftIcon className="h-4 w-4 mr-2" />
                                Back to Shop
                            </Link>

                            {/* Product Title & Vendor */}
                            <div>
                                <h1 className="text-3xl font-bold text-secondary-800 mb-2">{product.name}</h1>
                                <Link 
                                    href={`/vendors/${product.vendor.slug}`}
                                    className="text-primary-600 hover:text-primary-700 font-medium"
                                >
                                    by {product.vendor.store_name}
                                </Link>
                            </div>

                            {/* Rating */}
                            <div className="flex items-center space-x-4">
                                <div className="flex items-center">
                                    {renderStars(product.average_rating || 0)}
                                </div>
                                <span className="text-gray-600">
                                    {product.average_rating ? Number(product.average_rating).toFixed(1) : '0.0'} ({product.review_count || 0} reviews)
                                </span>
                            </div>

                            {/* Price */}
                            <div className="flex items-center space-x-4">
                                <span className="text-4xl font-bold text-secondary-800">
                                    ₦{currentPrice.toLocaleString()}
                                </span>
                                {hasDiscount && (
                                    <>
                                        <span className="text-xl text-gray-500 line-through">
                                            ₦{product.price.toLocaleString()}
                                        </span>
                                        <span className="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            {discountPercentage}% OFF
                                        </span>
                                    </>
                                )}
                            </div>

                            {/* Stock Status */}
                            <div className="flex items-center space-x-2">
                                {product.stock_quantity > 0 ? (
                                    <>
                                        <CheckCircleIcon className="h-5 w-5 text-green-500" />
                                        <span className="text-green-700 font-medium">In Stock</span>
                                        {product.stock_quantity <= 10 && (
                                            <span className="text-orange-600 text-sm">
                                                (Only {product.stock_quantity} left)
                                            </span>
                                        )}
                                    </>
                                ) : (
                                    <>
                                        <div className="h-5 w-5 bg-red-500 rounded-full"></div>
                                        <span className="text-red-700 font-medium">Out of Stock</span>
                                    </>
                                )}
                            </div>

                            {/* Quantity & Add to Cart */}
                            {product.stock_quantity > 0 && (
                                <div className="space-y-4">
                                    <div className="flex items-center space-x-4">
                                        <span className="text-gray-700 font-medium">Quantity:</span>
                                        <div className="flex items-center space-x-2">
                                            <button
                                                onClick={() => updateQuantity(quantity - 1)}
                                                disabled={quantity <= 1}
                                                className="w-10 h-10 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-full transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                            >
                                                <MinusIcon className="h-4 w-4" />
                                            </button>
                                            <span className="text-xl font-semibold min-w-[3rem] text-center">
                                                {quantity}
                                            </span>
                                            <button
                                                onClick={() => updateQuantity(quantity + 1)}
                                                disabled={quantity >= Math.min(10, product.stock_quantity)}
                                                className="w-10 h-10 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-full transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                            >
                                                <PlusIcon className="h-4 w-4" />
                                            </button>
                                        </div>
                                    </div>

                                    <div className="flex space-x-4">
                                        <button
                                            onClick={addToCart}
                                            disabled={isAddingToCart}
                                            className="flex-1 bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-6 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                                        >
                                            <ShoppingCartIcon className="h-5 w-5" />
                                            <span>{isAddingToCart ? 'Adding...' : 'Add to Cart'}</span>
                                        </button>
                                        
                                        <button
                                            onClick={toggleWishlist}
                                            disabled={isAddingToWishlist}
                                            className="p-3 border-2 border-gray-300 hover:border-red-300 rounded-2xl transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            {isInWishlist ? (
                                                <HeartSolidIcon className="h-6 w-6 text-red-500" />
                                            ) : (
                                                <HeartIcon className="h-6 w-6 text-gray-400 hover:text-red-500" />
                                            )}
                                        </button>
                                        
                                        <button className="p-3 border-2 border-gray-300 hover:border-gray-400 rounded-2xl transition-colors">
                                            <ShareIcon className="h-6 w-6 text-gray-400" />
                                        </button>
                                    </div>
                                </div>
                            )}

                            {/* Features */}
                            <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6 border-t border-gray-200">
                                <div className="flex items-center space-x-3">
                                    <TruckIcon className="h-6 w-6 text-primary-500" />
                                    <div>
                                        <div className="font-medium text-secondary-800">Free Shipping</div>
                                        <div className="text-sm text-gray-600">On orders over ₦50,000</div>
                                    </div>
                                </div>
                                <div className="flex items-center space-x-3">
                                    <ShieldCheckIcon className="h-6 w-6 text-green-500" />
                                    <div>
                                        <div className="font-medium text-secondary-800">Secure Payment</div>
                                        <div className="text-sm text-gray-600">100% secure checkout</div>
                                    </div>
                                </div>
                                <div className="flex items-center space-x-3">
                                    <EyeIcon className="h-6 w-6 text-blue-500" />
                                    <div>
                                        <div className="font-medium text-secondary-800">Quality Guarantee</div>
                                        <div className="text-sm text-gray-600">Verified products</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Product Details Tabs */}
                    <div className="mt-16">
                        <div className="border-b border-gray-200">
                            <nav className="flex space-x-8">
                                {['description', 'specifications', 'reviews'].map((tab) => (
                                    <button
                                        key={tab}
                                        onClick={() => setActiveTab(tab)}
                                        className={`py-4 px-1 border-b-2 font-medium text-sm capitalize transition-colors ${
                                            activeTab === tab
                                                ? 'border-primary-500 text-primary-600'
                                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                        }`}
                                    >
                                        {tab}
                                    </button>
                                ))}
                            </nav>
                        </div>

                        <div className="py-8">
                            {activeTab === 'description' && (
                                <div className="prose max-w-none">
                                    <p className="text-gray-700 leading-relaxed">
                                        {product.description || 'No description available for this product.'}
                                    </p>
                                </div>
                            )}

                            {activeTab === 'specifications' && (
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 className="font-semibold text-secondary-800 mb-4">Product Details</h3>
                                        <dl className="space-y-3">
                                            <div className="flex justify-between">
                                                <dt className="text-gray-600">SKU:</dt>
                                                <dd className="font-medium">{product.sku || 'N/A'}</dd>
                                            </div>
                                            <div className="flex justify-between">
                                                <dt className="text-gray-600">Category:</dt>
                                                <dd className="font-medium">{product.category.name}</dd>
                                            </div>
                                            <div className="flex justify-between">
                                                <dt className="text-gray-600">Vendor:</dt>
                                                <dd className="font-medium">{product.vendor.store_name}</dd>
                                            </div>
                                            <div className="flex justify-between">
                                                <dt className="text-gray-600">Weight:</dt>
                                                <dd className="font-medium">{product.weight || 'N/A'}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>
                            )}

                            {activeTab === 'reviews' && (
                                <div className="space-y-6">
                                    {reviews.length > 0 ? (
                                        reviews.map((review) => (
                                            <div key={review.id} className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                                <div className="flex items-start justify-between mb-4">
                                                    <div>
                                                        <h4 className="font-semibold text-secondary-800">{review.user.name}</h4>
                                                        <div className="flex items-center mt-1">
                                                            {renderStars(review.rating)}
                                                        </div>
                                                    </div>
                                                    <span className="text-sm text-gray-500">
                                                        {new Date(review.created_at).toLocaleDateString()}
                                                    </span>
                                                </div>
                                                <p className="text-gray-700">{review.comment}</p>
                                            </div>
                                        ))
                                    ) : (
                                        <div className="text-center py-8">
                                            <p className="text-gray-500">No reviews yet. Be the first to review this product!</p>
                                        </div>
                                    )}
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Related Products */}
                    {relatedProducts.length > 0 && (
                        <div className="mt-16">
                            <h2 className="text-2xl font-bold text-secondary-800 mb-8">Related Products</h2>
                            <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                {relatedProducts.map((relatedProduct) => (
                                    <Link
                                        key={relatedProduct.id}
                                        href={`/products/${relatedProduct.slug}`}
                                        className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow"
                                    >
                                        <div className="aspect-square bg-gray-100 flex items-center justify-center">
                                            <ShoppingCartIcon className="h-12 w-12 text-gray-300" />
                                        </div>
                                        <div className="p-4">
                                            <h3 className="font-semibold text-secondary-800 mb-2 line-clamp-2">
                                                {relatedProduct.name}
                                            </h3>
                                            <div className="flex items-center justify-between">
                                                <span className="font-bold text-primary-600">
                                                    ₦{(relatedProduct.sale_price || relatedProduct.price).toLocaleString()}
                                                </span>
                                                {relatedProduct.sale_price && (
                                                    <span className="text-sm text-gray-500 line-through">
                                                        ₦{relatedProduct.price.toLocaleString()}
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                    </Link>
                                ))}
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
