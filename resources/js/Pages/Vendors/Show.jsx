import { Head, Link, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    ShoppingCartIcon,
    HeartIcon,
    StarIcon,
    AdjustmentsHorizontalIcon,
    MagnifyingGlassIcon,
    ArrowLeftIcon,
    BuildingStorefrontIcon,
    MapPinIcon,
    PhoneIcon,
    EnvelopeIcon,
    ClockIcon,
    CheckBadgeIcon,
    PlusIcon,
    MinusIcon,
    EyeIcon,
    GlobeAltIcon,
    ChatBubbleLeftRightIcon
} from '@heroicons/react/24/outline';
import { useState } from 'react';

export default function VendorShow({ vendor, products, filters = {} }) {
    const [searchTerm, setSearchTerm] = useState(filters.search || '');
    const [showFilters, setShowFilters] = useState(false);
    const [quantities, setQuantities] = useState({});
    const [showQuantitySelector, setShowQuantitySelector] = useState({});

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(`/vendors/${vendor.slug}`, { ...filters, search: searchTerm });
    };

    const handleFilter = (key, value) => {
        router.get(`/vendors/${vendor.slug}`, { ...filters, [key]: value });
    };

    const handleSort = (sortBy) => {
        router.get(`/vendors/${vendor.slug}`, { ...filters, sort: sortBy });
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
            <Head title={`${vendor.store_name} - eProShop`} />
            
            <div className="min-h-screen bg-gray-50">
                {/* Vendor Header */}
                <div className="bg-white shadow-sm border-b border-gray-200">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <Link
                            href="/vendors"
                            className="inline-flex items-center text-gray-600 hover:text-primary-600 transition-colors mb-6"
                        >
                            <ArrowLeftIcon className="h-4 w-4 mr-2" />
                            Back to Vendors
                        </Link>

                        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            {/* Vendor Info */}
                            <div className="lg:col-span-2">
                                <div className="flex items-start gap-6 space-x-6">
                                    {/* Vendor Logo */}
                                    <div className="w-16 h-16 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center flex-shrink-0">
                                        <BuildingStorefrontIcon className="h-8 w-8 text-primary-600" />
                                    </div>

                                    {/* Vendor Details */}
                                    <div className="flex-1">
                                        <div className="flex items-center space-x-3 mb-2">
                                            <h1 className="text-3xl font-bold text-secondary-800">{vendor.store_name}</h1>
                                            {vendor.is_verified && (
                                                <CheckBadgeIcon className="h-8 w-8 text-blue-500" title="Verified Vendor" />
                                            )}
                                        </div>
                                        
                                        {vendor.description && (
                                            <p className="text-gray-600 mb-4 leading-relaxed">
                                                {vendor.description}
                                            </p>
                                        )}

                                        {/* Rating */}
                                        <div className="flex items-center space-x-4 mb-4">
                                            <div className="flex items-center">
                                                {[...Array(5)].map((_, i) => (
                                                    <StarIcon 
                                                        key={i} 
                                                        className={`h-5 w-5 ${i < Math.floor(vendor.average_rating || 0) ? 'text-yellow-400 fill-current' : 'text-gray-300'}`} 
                                                    />
                                                ))}
                                            </div>
                                            <span className="text-gray-600">
                                                {vendor.average_rating ? Number(vendor.average_rating).toFixed(1) : '0.0'} ({vendor.review_count || 0} reviews)
                                            </span>
                                        </div>

                                        {/* Stats */}
                                        <div className="grid grid-cols-3 gap-4">
                                            <div className="text-center p-4 bg-gray-50 rounded-xl">
                                                <div className="text-2xl font-bold text-secondary-800">{products.data.length}</div>
                                                <div className="text-sm text-gray-600">Products</div>
                                            </div>
                                            <div className="text-center p-4 bg-gray-50 rounded-xl">
                                                <div className="text-2xl font-bold text-secondary-800">{vendor.total_sales || 0}</div>
                                                <div className="text-sm text-gray-600">Sales</div>
                                            </div>
                                            <div className="text-center p-4 bg-gray-50 rounded-xl">
                                                <div className="text-2xl font-bold text-secondary-800">
                                                    {vendor.created_at ? new Date(vendor.created_at).getFullYear() : 'N/A'}
                                                </div>
                                                <div className="text-sm text-gray-600">Since</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Contact Info */}
                            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <h3 className="text-lg font-semibold text-secondary-800 mb-6">Contact Information</h3>
                                <div className="space-y-4">
                                    {/* Location */}
                                    {vendor.address && (
                                        <div className="flex items-start space-x-4">
                                            <div className="w-10 h-10 bg-primary-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <MapPinIcon className="h-5 w-5 text-primary-600" />
                                            </div>
                                            <div>
                                                <div className="font-medium text-secondary-800 text-sm">Location</div>
                                                <span className="text-gray-600 text-sm leading-relaxed">{vendor.address}</span>
                                            </div>
                                        </div>
                                    )}
                                    
                                    {/* Phone */}
                                    {vendor.phone && (
                                        <div className="flex items-center space-x-4">
                                            <div className="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <PhoneIcon className="h-5 w-5 text-green-600" />
                                            </div>
                                            <div>
                                                <div className="font-medium text-secondary-800 text-sm">Phone</div>
                                                <a href={`tel:${vendor.phone}`} className="text-gray-600 text-sm hover:text-primary-600 transition-colors">
                                                    {vendor.phone}
                                                </a>
                                            </div>
                                        </div>
                                    )}
                                    
                                    {/* Email */}
                                    {vendor.email && (
                                        <div className="flex items-center space-x-4">
                                            <div className="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <EnvelopeIcon className="h-5 w-5 text-blue-600" />
                                            </div>
                                            <div>
                                                <div className="font-medium text-secondary-800 text-sm">Email</div>
                                                <a href={`mailto:${vendor.email}`} className="text-gray-600 text-sm hover:text-primary-600 transition-colors">
                                                    {vendor.email}
                                                </a>
                                            </div>
                                        </div>
                                    )}
                                    
                                    {/* Website */}
                                    {vendor.website && (
                                        <div className="flex items-center space-x-4">
                                            <div className="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <GlobeAltIcon className="h-5 w-5 text-purple-600" />
                                            </div>
                                            <div>
                                                <div className="font-medium text-secondary-800 text-sm">Website</div>
                                                <a href={vendor.website} target="_blank" rel="noopener noreferrer" className="text-gray-600 text-sm hover:text-primary-600 transition-colors">
                                                    {vendor.website.replace(/^https?:\/\//, '')}
                                                </a>
                                            </div>
                                        </div>
                                    )}
                                    
                                    {/* Business Hours */}
                                    <div className="flex items-center space-x-4">
                                        <div className="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <ClockIcon className="h-5 w-5 text-orange-600" />
                                        </div>
                                        <div>
                                            <div className="font-medium text-secondary-800 text-sm">Business Hours</div>
                                            <span className="text-gray-600 text-sm">
                                                {vendor.business_hours || 'Mon-Fri: 9AM-6PM'}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {/* Social Media */}
                                <div className="mt-6 pt-6 border-t border-gray-100">
                                    <h4 className="font-medium text-secondary-800 text-sm mb-4">Connect With Us</h4>
                                    <div className="flex space-x-3">
                                        {vendor.facebook && (
                                            <a href={vendor.facebook} target="_blank" rel="noopener noreferrer" className="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center hover:bg-blue-700 transition-colors group">
                                                <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                </svg>
                                            </a>
                                        )}
                                        {vendor.twitter && (
                                            <a href={vendor.twitter} target="_blank" rel="noopener noreferrer" className="w-10 h-10 bg-sky-500 rounded-xl flex items-center justify-center hover:bg-sky-600 transition-colors group">
                                                <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                                </svg>
                                            </a>
                                        )}
                                        {vendor.instagram && (
                                            <a href={vendor.instagram} target="_blank" rel="noopener noreferrer" className="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-500 rounded-xl flex items-center justify-center hover:from-purple-700 hover:to-pink-600 transition-colors group">
                                                <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.418-3.323C6.001 8.198 7.152 7.708 8.449 7.708s2.448.49 3.323 1.418c.875.875 1.365 2.026 1.365 3.323s-.49 2.448-1.365 3.323c-.875.875-2.026 1.365-3.323 1.365zm7.718 0c-1.297 0-2.448-.49-3.323-1.297-.875-.875-1.365-2.026-1.365-3.323s.49-2.448 1.365-3.323c.875-.875 2.026-1.365 3.323-1.365s2.448.49 3.323 1.365c.875.875 1.365 2.026 1.365 3.323s-.49 2.448-1.365 3.323c-.875.875-2.026 1.365-3.323 1.365z"/>
                                                </svg>
                                            </a>
                                        )}
                                        {vendor.whatsapp && (
                                            <a href={`https://wa.me/${vendor.whatsapp.replace(/[^0-9]/g, '')}`} target="_blank" rel="noopener noreferrer" className="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center hover:bg-green-600 transition-colors group">
                                                <ChatBubbleLeftRightIcon className="w-5 h-5 text-white" />
                                            </a>
                                        )}
                                        {vendor.linkedin && (
                                            <a href={vendor.linkedin} target="_blank" rel="noopener noreferrer" className="w-10 h-10 bg-blue-700 rounded-xl flex items-center justify-center hover:bg-blue-800 transition-colors group">
                                                <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                                </svg>
                                            </a>
                                        )}
                                    </div>
                                </div>

                                {/* Contact Button */}
                                <button className="w-full mt-6 bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-4 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300 flex items-center justify-center space-x-2">
                                    <ChatBubbleLeftRightIcon className="h-5 w-5" />
                                    <span>Contact Vendor</span>
                                </button>
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
                                        placeholder={`Search ${vendor.store_name} products...`}
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

                                    {/* Category Filter */}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Category
                                        </label>
                                        <select
                                            value={filters.category || ''}
                                            onChange={(e) => handleFilter('category', e.target.value)}
                                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                                        >
                                            <option value="">All Categories</option>
                                            {/* Categories would be populated from props */}
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
                                <BuildingStorefrontIcon className="h-24 w-24 text-gray-300 mx-auto mb-6" />
                                <h2 className="text-2xl font-bold text-secondary-800 mb-4">No products found</h2>
                                <p className="text-gray-600 mb-8">
                                    This vendor hasn't added any products yet, or no products match your search criteria.
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
