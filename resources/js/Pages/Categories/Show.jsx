import { Head, Link, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    ShoppingCartIcon,
    HeartIcon,
    StarIcon,
    AdjustmentsHorizontalIcon,
    MagnifyingGlassIcon,
    ArrowLeftIcon,
    TagIcon,
    PlusIcon,
    MinusIcon,
    EyeIcon
} from '@heroicons/react/24/outline';
import { useState } from 'react';

export default function CategoryShow({ category, products, filters = {}, vendors = [] }) {
    const [searchTerm, setSearchTerm] = useState(filters.search || '');
    const [showFilters, setShowFilters] = useState(false);
    const [quantities, setQuantities] = useState({});
    const [showQuantitySelector, setShowQuantitySelector] = useState({});

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(`/categories/${category.slug}`, { ...filters, search: searchTerm });
    };

    const handleFilter = (key, value) => {
        router.get(`/categories/${category.slug}`, { ...filters, [key]: value });
    };

    const handleSort = (sortBy) => {
        router.get(`/categories/${category.slug}`, { ...filters, sort: sortBy });
    };

    const getQuantity = (productId) => {
        return quantities[productId] || 1;
    };

    const updateQuantity = (productId, newQuantity) => {
        if (newQuantity >= 1 && newQuantity <= 10) {
            setQuantities(prev => ({
                ...prev,
                [productId]: newQuantity
            }));
        }
    };

    const toggleQuantitySelector = (productId) => {
        setShowQuantitySelector(prev => ({
            ...prev,
            [productId]: !prev[productId]
        }));
        if (!quantities[productId]) {
            setQuantities(prev => ({
                ...prev,
                [productId]: 1
            }));
        }
    };

    const handleAddToCart = (product) => {
        const quantity = getQuantity(product.id);
        router.post('/cart/add', {
            product_id: product.id,
            quantity: quantity
        });
        setShowQuantitySelector(prev => ({
            ...prev,
            [product.id]: false
        }));
    };

    return (
        <AppLayout>
            <Head title={`${category.name} - eProShop`} />
            
            <div className="min-h-screen bg-gray-50">
                {/* Category Header */}
                <div className="bg-gradient-to-r from-primary-500 to-primary-600 text-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                        <div className="text-center">
                            <Link
                                href="/shop"
                                className="inline-flex items-center text-white/80 hover:text-white transition-colors mb-4"
                            >
                                <ArrowLeftIcon className="h-4 w-4 mr-2" />
                                Back to Shop
                            </Link>
                            <div className="flex items-center justify-center mb-4">
                                <TagIcon className="h-12 w-12 mr-4" />
                                <h1 className="text-4xl font-bold">{category.name}</h1>
                            </div>
                            {category.description && (
                                <p className="text-xl text-white/90 max-w-2xl mx-auto">
                                    {category.description}
                                </p>
                            )}
                            <div className="mt-6 text-white/80">
                                {products.data.length} product{products.data.length !== 1 ? 's' : ''} found
                            </div>
                        </div>
                    </div>
                </div>

                {/* Search and Filters */}
                <div className="bg-white shadow-sm border-b border-gray-200">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                        <div className="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                            {/* Search Bar */}
                            <div className="flex-1 max-w-md">
                                <form onSubmit={handleSearch} className="relative">
                                    <MagnifyingGlassIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
                                    <input
                                        type="text"
                                        value={searchTerm}
                                        onChange={(e) => setSearchTerm(e.target.value)}
                                        placeholder={`Search in ${category.name}...`}
                                        className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    />
                                </form>
                            </div>

                            {/* Filter Toggle & Sort */}
                            <div className="flex items-center space-x-4">
                                <button
                                    onClick={() => setShowFilters(!showFilters)}
                                    className="flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors"
                                >
                                    <AdjustmentsHorizontalIcon className="h-5 w-5" />
                                    <span>Filters</span>
                                </button>

                                <select
                                    value={filters.sort || 'created_at'}
                                    onChange={(e) => handleSort(e.target.value)}
                                    className="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500"
                                >
                                    <option value="created_at">Newest</option>
                                    <option value="price_low">Price: Low to High</option>
                                    <option value="price_high">Price: High to Low</option>
                                    <option value="rating">Best Rated</option>
                                    <option value="popular">Most Popular</option>
                                </select>
                            </div>
                        </div>

                        {/* Filters Panel */}
                        {showFilters && (
                            <div className="mt-6 p-6 bg-gray-50 rounded-2xl">
                                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    {/* Price Range */}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Price Range
                                        </label>
                                        <div className="flex space-x-2">
                                            <input
                                                type="number"
                                                placeholder="Min"
                                                className="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                            />
                                            <input
                                                type="number"
                                                placeholder="Max"
                                                className="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                            />
                                        </div>
                                    </div>

                                    {/* Vendor Filter */}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Vendor
                                        </label>
                                        <select
                                            value={filters.vendor || ''}
                                            onChange={(e) => handleFilter('vendor', e.target.value)}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                        >
                                            <option value="">All Vendors</option>
                                            {vendors.map((vendor) => (
                                                <option key={vendor.id} value={vendor.id}>
                                                    {vendor.store_name}
                                                </option>
                                            ))}
                                        </select>
                                    </div>

                                    {/* Rating Filter */}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Minimum Rating
                                        </label>
                                        <select
                                            value={filters.rating || ''}
                                            onChange={(e) => handleFilter('rating', e.target.value)}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                        >
                                            <option value="">Any Rating</option>
                                            <option value="4">4+ Stars</option>
                                            <option value="3">3+ Stars</option>
                                            <option value="2">2+ Stars</option>
                                            <option value="1">1+ Stars</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                </div>

                {/* Products Grid */}
                <div className="w-full sm:w-10/12 mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {products.data.length > 0 ? (
                        <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4">
                            {products.data.map((product) => (
                                <div key={product.id} className="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition-all duration-300 border border-gray-100">
                                    <div className="relative">
                                        <div className="aspect-square bg-gray-100 flex items-center justify-center">
                                            <ShoppingCartIcon className="h-8 w-8 sm:h-12 sm:w-12 text-gray-400" />
                                        </div>
                                        {product.sale_price && (
                                            <div className="absolute top-2 left-2 bg-red-500 text-white px-1.5 py-0.5 rounded text-xs font-semibold">
                                                -{Math.round(((product.price - product.sale_price) / product.price) * 100)}%
                                            </div>
                                        )}
                                        <div className="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button className="bg-white p-1.5 rounded-full shadow-lg hover:bg-gray-50">
                                                <HeartIcon className="h-3 w-3 sm:h-4 sm:w-4 text-gray-600" />
                                            </button>
                                        </div>
                                    </div>
                                    <div className="p-2 sm:p-3">
                                        <div className="text-xs text-primary-600 mb-1 truncate">{product.vendor.store_name}</div>
                                        <Link 
                                            href={`/products/${product.slug}`}
                                            className="block"
                                        >
                                            <h3 className="text-sm font-medium text-secondary-800 mb-2 line-clamp-2 hover:text-primary-600 leading-tight">
                                                {product.name}
                                            </h3>
                                        </Link>
                                        <div className="flex items-center mb-2">
                                            <div className="flex items-center">
                                                {[...Array(5)].map((_, i) => (
                                                    <StarIcon 
                                                        key={i} 
                                                        className={`h-3 w-3 ${i < Math.floor(product.average_rating || 0) ? 'text-yellow-400 fill-current' : 'text-gray-300'}`} 
                                                    />
                                                ))}
                                            </div>
                                            <span className="text-xs text-gray-500 ml-1">({product.review_count || 0})</span>
                                        </div>
                                        <div className="space-y-2">
                                            <div className="flex flex-col space-y-1">
                                                <span className="text-sm sm:text-base font-bold text-secondary-800">
                                                    ₦{(product.sale_price || product.price).toLocaleString()}
                                                </span>
                                                {product.sale_price && (
                                                    <span className="text-xs text-gray-500 line-through">
                                                        ₦{product.price.toLocaleString()}
                                                    </span>
                                                )}
                                            </div>
                                            
                                            {/* Quantity Selector */}
                                            {showQuantitySelector[product.id] && (
                                                <div className="flex items-center justify-center space-x-2 py-2 bg-gray-50 rounded-lg">
                                                    <button
                                                        onClick={() => updateQuantity(product.id, getQuantity(product.id) - 1)}
                                                        className="w-6 h-6 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded-full transition-colors"
                                                        disabled={getQuantity(product.id) <= 1}
                                                    >
                                                        <MinusIcon className="h-3 w-3" />
                                                    </button>
                                                    <span className="text-sm font-semibold min-w-[2rem] text-center">
                                                        {getQuantity(product.id)}
                                                    </span>
                                                    <button
                                                        onClick={() => updateQuantity(product.id, getQuantity(product.id) + 1)}
                                                        className="w-6 h-6 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded-full transition-colors"
                                                        disabled={getQuantity(product.id) >= 10}
                                                    >
                                                        <PlusIcon className="h-3 w-3" />
                                                    </button>
                                                </div>
                                            )}
                                            
                                            {/* Action Buttons */}
                                            <div className="flex space-x-1">
                                                {!showQuantitySelector[product.id] ? (
                                                    <>
                                                        <button 
                                                            onClick={() => toggleQuantitySelector(product.id)}
                                                            className="flex-1 bg-primary-500 text-white py-1.5 sm:py-2 rounded-lg hover:bg-primary-600 transition-colors text-xs sm:text-sm font-medium flex items-center justify-center space-x-1"
                                                        >
                                                            <ShoppingCartIcon className="h-3 w-3" />
                                                            <span>Add to Cart</span>
                                                        </button>
                                                        <Link
                                                            href={`/products/${product.slug}`}
                                                            className="px-2 py-1.5 sm:py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors flex items-center justify-center"
                                                        >
                                                            <EyeIcon className="h-3 w-3 sm:h-4 sm:w-4 text-gray-600" />
                                                        </Link>
                                                    </>
                                                ) : (
                                                    <>
                                                        <button 
                                                            onClick={() => handleAddToCart(product)}
                                                            className="flex-1 bg-green-500 text-white py-1.5 sm:py-2 rounded-lg hover:bg-green-600 transition-colors text-xs sm:text-sm font-medium"
                                                        >
                                                            Add {getQuantity(product.id)} to Cart
                                                        </button>
                                                        <button
                                                            onClick={() => toggleQuantitySelector(product.id)}
                                                            className="px-2 py-1.5 sm:py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors text-xs"
                                                        >
                                                            Cancel
                                                        </button>
                                                    </>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="text-center py-16">
                            <div className="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 max-w-md mx-auto">
                                <TagIcon className="h-24 w-24 text-gray-300 mx-auto mb-6" />
                                <h2 className="text-2xl font-bold text-secondary-800 mb-4">No products found</h2>
                                <p className="text-gray-600 mb-8">
                                    No products found in this category. Try adjusting your search or filters.
                                </p>
                                <Link
                                    href="/shop"
                                    className="inline-flex items-center space-x-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-6 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300"
                                >
                                    <span>Browse All Products</span>
                                </Link>
                            </div>
                        </div>
                    )}

                    {/* Pagination */}
                    {products.links && products.links.length > 3 && (
                        <div className="mt-12 flex justify-center">
                            <nav className="flex items-center space-x-2">
                                {products.links.map((link, index) => (
                                    <Link
                                        key={index}
                                        href={link.url || '#'}
                                        className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
                                            link.active
                                                ? 'bg-primary-500 text-white'
                                                : link.url
                                                ? 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300'
                                                : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                        }`}
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                    />
                                ))}
                            </nav>
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
