import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    ShoppingBagIcon, 
    TruckIcon, 
    ShieldCheckIcon, 
    CreditCardIcon,
    StarIcon,
    ArrowRightIcon,
    HeartIcon,
    EyeIcon
} from '@heroicons/react/24/outline';

export default function Home({ auth, featuredProducts = [], categories = [], vendors = [] }) {
    const features = [
        {
            icon: TruckIcon,
            title: 'Free Delivery',
            description: 'Free shipping on orders over ₦50,000'
        },
        {
            icon: ShieldCheckIcon,
            title: 'Secure Payment',
            description: 'Your payment information is safe with us'
        },
        {
            icon: CreditCardIcon,
            title: 'Cooperative Benefits',
            description: 'Special discounts for cooperative members'
        },
        {
            icon: ShoppingBagIcon,
            title: 'Multi-Vendor',
            description: 'Shop from thousands of trusted vendors'
        }
    ];

    const demoProducts = [
        {
            id: 1,
            name: 'Samsung Galaxy S24',
            price: 450000,
            sale_price: 420000,
            images: ['/images/demo/phone1.jpg'],
            vendor: { store_name: 'TechHub Nigeria' },
            average_rating: 4.5,
            review_count: 128
        },
        {
            id: 2,
            name: 'Nike Air Max 270',
            price: 85000,
            images: ['/images/demo/shoe1.jpg'],
            vendor: { store_name: 'SportZone' },
            average_rating: 4.8,
            review_count: 89
        },
        {
            id: 3,
            name: 'MacBook Pro M3',
            price: 1200000,
            sale_price: 1150000,
            images: ['/images/demo/laptop1.jpg'],
            vendor: { store_name: 'Apple Store NG' },
            average_rating: 4.9,
            review_count: 245
        }
    ];

    return (
        <AppLayout>
            <Head title="Welcome to eProShop - Nigeria's Premier Multi-Vendor Marketplace" />
            
            {/* Hero Section */}
            <section className="relative bg-gradient-to-br from-primary-500 via-primary-600 to-secondary-800 text-white overflow-hidden">
                <div className="absolute inset-0 bg-black/20"></div>
                <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div className="text-center lg:text-left">
                            <h1 className="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                                Nigeria's Premier
                                <span className="block text-accent-400">Multi-Vendor</span>
                                <span className="block">Marketplace</span>
                            </h1>
                            <p className="text-xl mb-8 text-gray-200">
                                Shop from thousands of trusted vendors. Enjoy cooperative member benefits 
                                and secure payments. Your one-stop destination for everything!
                            </p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                <Link 
                                    href="/shop" 
                                    className="bg-accent-500 text-secondary-800 px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-accent-400 transition-all duration-300 transform hover:scale-105 shadow-lg"
                                >
                                    Start Shopping
                                </Link>
                                <Link 
                                    href="/vendors/register" 
                                    className="border-2 border-white text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-white hover:text-primary-600 transition-all duration-300"
                                >
                                    Become a Vendor
                                </Link>
                            </div>
                        </div>
                        <div className="relative">
                            <div className="bg-white/10 backdrop-blur-sm rounded-3xl p-8 shadow-2xl">
                                <div className="grid grid-cols-2 gap-4">
                                    <div className="bg-white/20 rounded-2xl p-4 text-center">
                                        <div className="text-3xl font-bold">10K+</div>
                                        <div className="text-sm">Products</div>
                                    </div>
                                    <div className="bg-white/20 rounded-2xl p-4 text-center">
                                        <div className="text-3xl font-bold">500+</div>
                                        <div className="text-sm">Vendors</div>
                                    </div>
                                    <div className="bg-white/20 rounded-2xl p-4 text-center">
                                        <div className="text-3xl font-bold">50K+</div>
                                        <div className="text-sm">Customers</div>
                                    </div>
                                    <div className="bg-white/20 rounded-2xl p-4 text-center">
                                        <div className="text-3xl font-bold">25+</div>
                                        <div className="text-sm">Cooperatives</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Features Section */}
            <section className="py-16 bg-white">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl font-bold text-secondary-800 mb-4">Why Choose eProShop?</h2>
                        <p className="text-gray-600 max-w-2xl mx-auto">
                            Experience the best of online shopping with our unique features designed for Nigerian consumers
                        </p>
                    </div>
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        {features.map((feature, index) => (
                            <div key={index} className="text-center group hover:transform hover:scale-105 transition-all duration-300">
                                <div className="bg-primary-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-500 transition-colors">
                                    <feature.icon className="h-8 w-8 text-primary-600 group-hover:text-white" />
                                </div>
                                <h3 className="text-xl font-semibold text-secondary-800 mb-2">{feature.title}</h3>
                                <p className="text-gray-600">{feature.description}</p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Featured Products */}
            <section className="py-16 bg-gray-50">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center mb-12">
                        <div>
                            <h2 className="text-3xl font-bold text-secondary-800 mb-2">Featured Products</h2>
                            <p className="text-gray-600">Discover our most popular items</p>
                        </div>
                        <Link 
                            href="/shop" 
                            className="flex items-center text-primary-600 hover:text-primary-700 font-semibold"
                        >
                            View All <ArrowRightIcon className="ml-2 h-5 w-5" />
                        </Link>
                    </div>
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {demoProducts.map((product) => (
                            <div key={product.id} className="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-all duration-300">
                                <div className="relative">
                                    <div className="aspect-square bg-gray-200 flex items-center justify-center">
                                        <ShoppingBagIcon className="h-16 w-16 text-gray-400" />
                                    </div>
                                    {product.sale_price && (
                                        <div className="absolute top-4 left-4 bg-red-500 text-white px-2 py-1 rounded-lg text-sm font-semibold">
                                            {Math.round(((product.price - product.sale_price) / product.price) * 100)}% OFF
                                        </div>
                                    )}
                                    <div className="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button className="bg-white p-2 rounded-full shadow-lg hover:bg-gray-50">
                                            <HeartIcon className="h-5 w-5 text-gray-600" />
                                        </button>
                                    </div>
                                </div>
                                <div className="p-6">
                                    <div className="text-sm text-primary-600 mb-2">{product.vendor.store_name}</div>
                                    <h3 className="text-lg font-semibold text-secondary-800 mb-2 line-clamp-2">{product.name}</h3>
                                    <div className="flex items-center mb-3">
                                        <div className="flex items-center">
                                            {[...Array(5)].map((_, i) => (
                                                <StarIcon 
                                                    key={i} 
                                                    className={`h-4 w-4 ${i < Math.floor(product.average_rating) ? 'text-yellow-400 fill-current' : 'text-gray-300'}`} 
                                                />
                                            ))}
                                        </div>
                                        <span className="text-sm text-gray-600 ml-2">({product.review_count})</span>
                                    </div>
                                    <div className="flex items-center justify-between">
                                        <div className="flex items-center space-x-2">
                                            <span className="text-xl font-bold text-secondary-800">
                                                ₦{(product.sale_price || product.price).toLocaleString()}
                                            </span>
                                            {product.sale_price && (
                                                <span className="text-sm text-gray-500 line-through">
                                                    ₦{product.price.toLocaleString()}
                                                </span>
                                            )}
                                        </div>
                                        <button className="bg-primary-500 text-white px-4 py-2 rounded-xl hover:bg-primary-600 transition-colors">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Categories Section */}
            <section className="py-16 bg-white">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl font-bold text-secondary-800 mb-4">Shop by Category</h2>
                        <p className="text-gray-600">Find exactly what you're looking for</p>
                    </div>
                    <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                        {['Electronics', 'Fashion', 'Home & Garden', 'Sports', 'Books', 'Automotive'].map((category, index) => (
                            <Link 
                                key={index}
                                href={`/categories/${category.toLowerCase().replace(' & ', '-').replace(' ', '-')}`}
                                className="group text-center"
                            >
                                <div className="bg-gray-100 rounded-2xl p-8 mb-4 group-hover:bg-primary-100 transition-colors">
                                    <ShoppingBagIcon className="h-12 w-12 text-gray-600 group-hover:text-primary-600 mx-auto" />
                                </div>
                                <h3 className="font-semibold text-secondary-800 group-hover:text-primary-600">{category}</h3>
                            </Link>
                        ))}
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="py-16 bg-secondary-800 text-white">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 className="text-3xl font-bold mb-4">Ready to Start Shopping?</h2>
                    <p className="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                        Join thousands of satisfied customers and discover amazing products from trusted vendors across Nigeria.
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                        <Link 
                            href="/register" 
                            className="bg-primary-500 text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-primary-600 transition-colors"
                        >
                            Create Account
                        </Link>
                        <Link 
                            href="/shop" 
                            className="border-2 border-accent-500 text-accent-500 px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-accent-500 hover:text-secondary-800 transition-colors"
                        >
                            Browse Products
                        </Link>
                    </div>
                </div>
            </section>
        </AppLayout>
    );
}
