import { Link, usePage } from '@inertiajs/react';
import { useState } from 'react';
import { 
    ShoppingBagIcon, 
    HeartIcon, 
    UserIcon, 
    MagnifyingGlassIcon,
    Bars3Icon,
    XMarkIcon,
    ShoppingCartIcon
} from '@heroicons/react/24/outline';

export default function AppLayout({ children }) {
    const { auth, cart } = usePage().props;
    const [showMobileMenu, setShowMobileMenu] = useState(false);
    const [showSearchBar, setShowSearchBar] = useState(false);

    const navigation = [
        { name: 'Home', href: '/' },
        { name: 'Shop', href: '/shop' },
        { name: 'Categories', href: '/categories' },
        { name: 'Vendors', href: '/vendors' },
        { name: 'About', href: '/about' },
    ];

    return (
        <div className="min-h-screen bg-gray-50">
            {/* Top Bar - Hidden on mobile, visible on tablet+ */}
            <div className="hidden sm:block bg-secondary-800 text-white text-xs sm:text-sm">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center py-2">
                        <div className="flex items-center space-x-2 sm:space-x-4">
                            <span className="hidden md:inline">📞 +234 800 123 4567</span>
                            <span className="hidden lg:inline">✉️ hello@eProShop.com</span>
                        </div>
                        <div className="flex items-center space-x-2 sm:space-x-4">
                            <span className="hidden md:inline">Free shipping on orders over ₦50,000</span>
                            {auth.user?.cooperative_id && (
                                <span className="bg-accent-500 text-secondary-800 px-2 py-1 rounded text-xs font-semibold">
                                    Cooperative Member
                                </span>
                            )}
                        </div>
                    </div>
                </div>
            </div>

            {/* Main Header */}
            <header className="bg-white shadow-lg sticky top-0 z-50">
                <div className="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center py-3 sm:py-4">
                        {/* Logo */}
                        <div className="flex items-center flex-shrink-0">
                            <Link href="/" className="flex items-center space-x-2">
                                <div className="w-8 h-8 sm:w-12 sm:h-12 flex items-center justify-center">
                                    <img 
                                        src="/real_logo_eProShop-removebg-preview.png" 
                                        alt="eProShop Logo" 
                                        className="w-8 h-8 sm:w-12 sm:h-12 object-contain"
                                    />
                                </div>
                                <div className="lg:block">
                                    <h1 className="text-lg sm:text-2xl font-bold text-secondary-800">eProShop</h1>
                                    <p className="text-xs text-gray-500 sm:block">Multi-Vendor Marketplace</p>
                                </div>
                            </Link>
                        </div>

                        {/* Search Bar - Desktop Only */}
                        <div className="hidden lg:flex flex-1 max-w-lg mx-8">
                            <div className="relative w-full">
                                <input
                                    type="text"
                                    placeholder="Search products, vendors, categories..."
                                    className="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                />
                                <button className="absolute right-2 top-1/2 transform -translate-y-1/2 bg-primary-500 text-white p-2 rounded-xl hover:bg-primary-600 transition-colors">
                                    <MagnifyingGlassIcon className="h-5 w-5" />
                                </button>
                            </div>
                        </div>

                        {/* Right Actions */}
                        <div className="flex items-center space-x-1 sm:space-x-2">
                            {/* Search Icon - Mobile & Tablet */}
                            <button 
                                className="lg:hidden p-2 text-gray-600 hover:text-primary-500 rounded-xl"
                                onClick={() => setShowSearchBar(!showSearchBar)}
                            >
                                <MagnifyingGlassIcon className="h-5 w-5 sm:h-6 sm:w-6" />
                            </button>

                            {/* Wishlist - Hidden on small mobile */}
                            <Link href="/wishlist" className="hidden xs:flex p-2 text-gray-600 hover:text-primary-500 relative rounded-xl">
                                <HeartIcon className="h-5 w-5 sm:h-6 sm:w-6" />
                                <span className="absolute -top-1 -right-1 bg-primary-500 text-white text-xs rounded-full h-4 w-4 sm:h-5 sm:w-5 flex items-center justify-center text-xs">
                                    0
                                </span>
                            </Link>

                            {/* Cart */}
                            <Link href="/cart" className="p-2 text-gray-600 hover:text-primary-500 relative rounded-xl">
                                <ShoppingCartIcon className="h-5 w-5 sm:h-6 sm:w-6" />
                                <span className="absolute -top-1 -right-1 bg-primary-500 text-white text-xs rounded-full h-4 w-4 sm:h-5 sm:w-5 flex items-center justify-center">
                                    {cart?.items_count || 0}
                                </span>
                            </Link>

                            {/* User Menu */}
                            {auth.user ? (
                                <div className="relative">
                                    <Link href="/dashboard" className="flex items-center space-x-1 sm:space-x-2 p-2 text-gray-600 hover:text-primary-500 rounded-xl">
                                        <UserIcon className="h-5 w-5 sm:h-6 sm:w-6" />
                                        <span className="hidden md:block text-sm truncate max-w-20">{auth.user.name}</span>
                                    </Link>
                                </div>
                            ) : (
                                <div className="hidden sm:flex items-center space-x-2">
                                    <Link 
                                        href="/login" 
                                        className="text-gray-600 hover:text-primary-500 px-3 py-2 text-sm"
                                    >
                                        Login
                                    </Link>
                                    <Link 
                                        href="/register" 
                                        className="bg-primary-500 text-white px-3 sm:px-4 py-2 rounded-2xl hover:bg-primary-600 transition-colors text-sm"
                                    >
                                        Sign Up
                                    </Link>
                                </div>
                            )}

                            {/* Mobile Menu Button */}
                            <button
                                className="md:hidden p-2 text-gray-600 hover:text-primary-500 rounded-xl"
                                onClick={() => setShowMobileMenu(!showMobileMenu)}
                            >
                                {showMobileMenu ? (
                                    <XMarkIcon className="h-6 w-6" />
                                ) : (
                                    <Bars3Icon className="h-6 w-6" />
                                )}
                            </button>
                        </div>
                    </div>

                    {/* Mobile Search Bar */}
                    {showSearchBar && (
                        <div className="lg:hidden px-3 sm:px-6 pb-4 bg-white border-t border-gray-100">
                            <div className="relative mt-4">
                                <input
                                    type="text"
                                    placeholder="Search products..."
                                    className="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm"
                                />
                                <button className="absolute right-2 top-1/2 transform -translate-y-1/2 bg-primary-500 text-white p-2 rounded-xl hover:bg-primary-600 transition-colors">
                                    <MagnifyingGlassIcon className="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                    )}
                </div>

                {/* Navigation Menu */}
                <nav className="border-t border-gray-200">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="hidden md:flex space-x-8 py-3">
                            {navigation.map((item) => (
                                <Link
                                    key={item.name}
                                    href={item.href}
                                    className="text-gray-700 hover:text-primary-500 px-3 py-2 text-sm font-medium transition-colors"
                                >
                                    {item.name}
                                </Link>
                            ))}
                        </div>
                    </div>
                </nav>

                {/* Mobile Navigation */}
                {showMobileMenu && (
                    <div className="md:hidden border-t border-gray-200 bg-white shadow-lg">
                        <div className="px-3 py-4 space-y-1">
                            {navigation.map((item) => (
                                <Link
                                    key={item.name}
                                    href={item.href}
                                    className="block text-gray-700 hover:text-primary-500 hover:bg-primary-50 px-4 py-3 text-base font-medium rounded-xl transition-colors"
                                    onClick={() => setShowMobileMenu(false)}
                                >
                                    {item.name}
                                </Link>
                            ))}
                            
                            {/* Mobile-only links */}
                            <Link
                                href="/wishlist"
                                className="xs:hidden block text-gray-700 hover:text-primary-500 hover:bg-primary-50 px-4 py-3 text-base font-medium rounded-xl transition-colors"
                                onClick={() => setShowMobileMenu(false)}
                            >
                                Wishlist
                            </Link>
                            
                            {!auth.user && (
                                <div className="pt-4 mt-4 border-t border-gray-200 space-y-1">
                                    <Link 
                                        href="/login" 
                                        className="block text-gray-700 hover:text-primary-500 hover:bg-primary-50 px-4 py-3 text-base font-medium rounded-xl transition-colors"
                                        onClick={() => setShowMobileMenu(false)}
                                    >
                                        Login
                                    </Link>
                                    <Link 
                                        href="/register" 
                                        className="block bg-primary-500 text-white hover:bg-primary-600 px-4 py-3 text-base font-medium rounded-xl transition-colors"
                                        onClick={() => setShowMobileMenu(false)}
                                    >
                                        Sign Up
                                    </Link>
                                </div>
                            )}
                            
                            {auth.user && (
                                <div className="pt-4 mt-4 border-t border-gray-200 space-y-1">
                                    <Link 
                                        href="/dashboard" 
                                        className="block text-gray-700 hover:text-primary-500 hover:bg-primary-50 px-4 py-3 text-base font-medium rounded-xl transition-colors"
                                        onClick={() => setShowMobileMenu(false)}
                                    >
                                        Dashboard
                                    </Link>
                                    <Link 
                                        href="/profile" 
                                        className="block text-gray-700 hover:text-primary-500 hover:bg-primary-50 px-4 py-3 text-base font-medium rounded-xl transition-colors"
                                        onClick={() => setShowMobileMenu(false)}
                                    >
                                        Profile
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>
                )}
            </header>

            {/* Main Content */}
            <main className="flex-1">
                {children}
            </main>

            {/* Footer */}
            <footer className="bg-secondary-800 text-white">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                        {/* Company Info */}
                        <div className="col-span-1 sm:col-span-2 lg:col-span-2">
                            <div className="flex items-center space-x-2 mb-4">
                                <div className="bg-primary-500 text-white p-2 rounded-xl">
                                    <ShoppingBagIcon className="h-5 w-5 sm:h-6 sm:w-6" />
                                </div>
                                <h3 className="text-lg sm:text-xl font-bold">eProShop</h3>
                            </div>
                            <p className="text-gray-300 mb-4 text-sm sm:text-base leading-relaxed">
                                Nigeria's premier multi-vendor cooperative e-commerce platform. 
                                Shop from trusted vendors and enjoy cooperative member benefits.
                            </p>
                            <div className="flex flex-wrap gap-4">
                                <a href="#" className="text-gray-300 hover:text-accent-500 transition-colors text-sm">Facebook</a>
                                <a href="#" className="text-gray-300 hover:text-accent-500 transition-colors text-sm">Twitter</a>
                                <a href="#" className="text-gray-300 hover:text-accent-500 transition-colors text-sm">Instagram</a>
                                <a href="#" className="text-gray-300 hover:text-accent-500 transition-colors text-sm">LinkedIn</a>
                            </div>
                        </div>

                        {/* Quick Links */}
                        <div>
                            <h4 className="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Quick Links</h4>
                            <ul className="space-y-2">
                                <li><Link href="/about" className="text-gray-300 hover:text-accent-500 transition-colors text-sm">About Us</Link></li>
                                <li><Link href="/vendors/register" className="text-gray-300 hover:text-accent-500 transition-colors text-sm">Become a Vendor</Link></li>
                                <li><Link href="/categories" className="text-gray-300 hover:text-accent-500 transition-colors text-sm">Categories</Link></li>
                                <li><Link href="/shop" className="text-gray-300 hover:text-accent-500 transition-colors text-sm">Shop</Link></li>
                            </ul>
                        </div>

                        {/* Customer Service */}
                        <div>
                            <h4 className="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Support</h4>
                            <ul className="space-y-2">
                                <li><a href="tel:+2348001234567" className="text-gray-300 hover:text-accent-500 transition-colors text-sm">Help Center</a></li>
                                <li><a href="mailto:hello@eProShop.com" className="text-gray-300 hover:text-accent-500 transition-colors text-sm">Contact Us</a></li>
                                <li><Link href="/shipping" className="text-gray-300 hover:text-accent-500 transition-colors text-sm">Shipping Info</Link></li>
                                <li><Link href="/privacy" className="text-gray-300 hover:text-accent-500 transition-colors text-sm">Privacy Policy</Link></li>
                            </ul>
                        </div>
                    </div>

                    <div className="border-t border-gray-700 mt-6 sm:mt-8 pt-6 sm:pt-8 text-center">
                        <p className="text-gray-300 text-xs sm:text-sm">
                            © 2024 eProShop. All rights reserved. Built with ❤️ for Nigerian cooperatives.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    );
}
