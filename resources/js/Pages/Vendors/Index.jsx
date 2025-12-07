import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    BuildingStorefrontIcon,
    StarIcon,
    MapPinIcon,
    ShoppingBagIcon,
    ArrowRightIcon
} from '@heroicons/react/24/outline';

export default function VendorsIndex({ vendors }) {
    return (
        <AppLayout>
            <Head title="Vendors - eProShop" />
            
            <div className="min-h-screen bg-gray-50">
                {/* Header */}
                <div className="bg-white shadow-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                        <div className="text-center">
                            <h1 className="text-4xl font-bold text-secondary-800 mb-4">Our Trusted Vendors</h1>
                            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
                                Discover amazing products from verified vendors across Nigeria
                            </p>
                        </div>
                    </div>
                </div>

                {/* Vendors Grid */}
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    {vendors.data.length > 0 ? (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {vendors.data.map((vendor) => (
                                <div
                                    key={vendor.id}
                                    className="group bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 border border-gray-100"
                                >
                                    {/* Vendor Header with Cover */}
                                    <div className="relative h-40 bg-gradient-to-br from-primary-500 via-primary-600 to-secondary-700 overflow-hidden">
                                        {/* Pattern Overlay */}
                                        <div className="absolute inset-0 opacity-10">
                                            <div className="absolute inset-0" style={{
                                                backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
                                            }}></div>
                                        </div>
                                        
                                        {/* Featured Badge */}
                                        {vendor.is_featured && (
                                            <div className="absolute top-4 right-4 bg-accent-500 text-secondary-800 px-3 py-1.5 rounded-full text-xs font-bold shadow-lg">
                                                ⭐ Featured
                                            </div>
                                        )}
                                        
                                        {/* Vendor Logo */}
                                        <div className="absolute -bottom-8 left-6">
                                            <div className="w-20 h-20 bg-white rounded-3xl shadow-xl flex items-center justify-center border-4 border-white group-hover:scale-110 transition-transform duration-300">
                                                {vendor.logo ? (
                                                    <img 
                                                        src={vendor.logo} 
                                                        alt={vendor.store_name}
                                                        className="w-14 h-14 rounded-2xl object-cover"
                                                    />
                                                ) : (
                                                    <BuildingStorefrontIcon className="h-10 w-10 text-primary-600" />
                                                )}
                                            </div>
                                        </div>
                                    </div>

                                    {/* Vendor Content */}
                                    <div className="pt-14 pb-6 px-6">
                                        {/* Store Name & Business Type */}
                                        <div className="mb-4">
                                            <h3 className="text-xl font-bold text-secondary-800 mb-2 group-hover:text-primary-600 transition-colors">
                                                {vendor.store_name}
                                            </h3>
                                            {vendor.business_type && (
                                                <div className="inline-block bg-primary-50 text-primary-700 px-3 py-1 rounded-full text-sm font-medium">
                                                    {vendor.business_type}
                                                </div>
                                            )}
                                        </div>
                                        
                                        {/* Description */}
                                        {vendor.description && (
                                            <p className="text-gray-600 mb-4 line-clamp-2 leading-relaxed">
                                                {vendor.description}
                                            </p>
                                        )}

                                        {/* Stats Row */}
                                        <div className="flex items-center justify-between mb-4 py-3 px-4 bg-gray-50 rounded-2xl">
                                            <div className="flex items-center text-sm">
                                                <div className="bg-primary-100 p-2 rounded-xl mr-3">
                                                    <ShoppingBagIcon className="h-4 w-4 text-primary-600" />
                                                </div>
                                                <div>
                                                    <div className="font-semibold text-secondary-800">{vendor.products_count}</div>
                                                    <div className="text-gray-500 text-xs">Products</div>
                                                </div>
                                            </div>
                                            
                                            <div className="flex items-center text-sm">
                                                <div className="bg-accent-100 p-2 rounded-xl mr-3">
                                                    <StarIcon className="h-4 w-4 text-accent-600" />
                                                </div>
                                                <div>
                                                    <div className="font-semibold text-secondary-800">4.8</div>
                                                    <div className="text-gray-500 text-xs">Rating</div>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Location */}
                                        {vendor.address && (
                                            <div className="flex items-center text-sm text-gray-500 mb-6 bg-gray-50 p-3 rounded-xl">
                                                <MapPinIcon className="h-4 w-4 mr-2 text-gray-400" />
                                                <span className="line-clamp-1">{vendor.address}</span>
                                            </div>
                                        )}

                                        {/* Visit Store Button */}
                                        <Link
                                            href={`/vendors/${vendor.slug}`}
                                            className="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-6 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-300 flex items-center justify-center space-x-2 group-hover:shadow-lg"
                                        >
                                            <span>Visit Store</span>
                                            <ArrowRightIcon className="h-5 w-5 group-hover:translate-x-1 transition-transform" />
                                        </Link>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="text-center py-12">
                            <BuildingStorefrontIcon className="h-16 w-16 text-gray-400 mx-auto mb-4" />
                            <h3 className="text-lg font-semibold text-gray-600 mb-2">No vendors found</h3>
                            <p className="text-gray-500">Vendors will appear here once they are approved</p>
                        </div>
                    )}

                    {/* Pagination */}
                    {vendors.links && vendors.links.length > 3 && (
                        <div className="mt-12 flex justify-center">
                            <nav className="flex items-center space-x-2">
                                {vendors.links.map((link, index) => (
                                    <Link
                                        key={index}
                                        href={link.url || '#'}
                                        className={`px-4 py-2 rounded-lg text-sm font-medium ${
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

                {/* Become a Vendor CTA */}
                <div className="bg-secondary-800 text-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                        <div className="text-center">
                            <BuildingStorefrontIcon className="h-16 w-16 text-primary-400 mx-auto mb-6" />
                            <h2 className="text-3xl font-bold mb-4">Want to become a vendor?</h2>
                            <p className="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                                Join hundreds of successful vendors on eProShop and grow your business 
                                with access to thousands of customers across Nigeria.
                            </p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Link 
                                    href="/vendors/register" 
                                    className="bg-primary-500 text-white px-8 py-4 rounded-2xl font-semibold hover:bg-primary-600 transition-colors"
                                >
                                    Apply to Become a Vendor
                                </Link>
                                <Link 
                                    href="/about" 
                                    className="border-2 border-accent-500 text-accent-500 px-8 py-4 rounded-2xl font-semibold hover:bg-accent-500 hover:text-secondary-800 transition-colors"
                                >
                                    Learn More
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Featured Categories */}
                <div className="bg-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                        <div className="text-center mb-12">
                            <h2 className="text-3xl font-bold text-secondary-800 mb-4">Explore by Category</h2>
                            <p className="text-gray-600">Find vendors specializing in different product categories</p>
                        </div>
                        
                        <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                            {['Electronics', 'Fashion', 'Home & Garden', 'Sports', 'Books', 'Automotive'].map((category, index) => (
                                <Link 
                                    key={index}
                                    href={`/categories/${category.toLowerCase().replace(' & ', '-').replace(' ', '-')}`}
                                    className="group text-center"
                                >
                                    <div className="bg-gray-100 rounded-2xl p-6 mb-3 group-hover:bg-primary-100 transition-colors">
                                        <ShoppingBagIcon className="h-8 w-8 text-gray-600 group-hover:text-primary-600 mx-auto" />
                                    </div>
                                    <h3 className="font-semibold text-secondary-800 group-hover:text-primary-600 text-sm">
                                        {category}
                                    </h3>
                                </Link>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
