import { Head, Link } from '@inertiajs/react';
import { 
    ShoppingBagIcon,
    HeartIcon,
    ClockIcon,
    CreditCardIcon,
    TruckIcon,
    StarIcon,
    UserIcon,
    ChartBarIcon,
    ArrowRightIcon,
    EyeIcon,
    ShoppingCartIcon
} from '@heroicons/react/24/outline';

export default function Dashboard({ auth, recentOrders = [], wishlistCount = 0, cartCount = 0, orderStats = {} }) {
    const user = auth.user;

    const quickStats = [
        {
            name: 'Total Orders',
            value: orderStats.total || 0,
            icon: ShoppingBagIcon,
            color: 'bg-blue-500',
            href: '/orders'
        },
        {
            name: 'Wishlist Items',
            value: wishlistCount,
            icon: HeartIcon,
            color: 'bg-red-500',
            href: '/wishlist'
        },
        {
            name: 'Cart Items',
            value: cartCount,
            icon: ShoppingCartIcon,
            color: 'bg-green-500',
            href: '/cart'
        },
        {
            name: 'Total Spent',
            value: `₦${(orderStats.totalSpent || 0).toLocaleString()}`,
            icon: CreditCardIcon,
            color: 'bg-purple-500',
            href: '/orders'
        }
    ];

    const getOrderStatusColor = (status) => {
        switch (status?.toLowerCase()) {
            case 'pending': return 'bg-yellow-100 text-yellow-800';
            case 'processing': return 'bg-blue-100 text-blue-800';
            case 'shipped': return 'bg-indigo-100 text-indigo-800';
            case 'delivered': return 'bg-green-100 text-green-800';
            case 'cancelled': return 'bg-red-100 text-red-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    };

    return (
        <div className="min-h-screen bg-gray-50">
            {/* Custom eProShop Header */}
            <div className="bg-white shadow-sm border-b border-gray-200">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between h-16">
                        {/* Logo and Navigation */}
                        <div className="flex items-center space-x-8">
                            <Link href="/dashboard" className="flex items-center space-x-3">
                                <div className="w-10 h-10 flex items-center justify-center">
                                    <img 
                                        src="/real_logo_eProShop-removebg-preview.png" 
                                        alt="eProShop Logo" 
                                        className="w-10 h-10 object-contain"
                                    />
                                </div>
                                <div>
                                    <h1 className="text-xl font-bold text-secondary-800">eProShop</h1>
                                    <p className="text-xs text-gray-500">Dashboard</p>
                                </div>
                            </Link>
                            
                            {/* Navigation Links */}
                            <nav className="hidden md:flex items-center space-x-6">
                                <Link href="/shop" className="text-gray-600 hover:text-primary-600 transition-colors font-medium">
                                    Shop
                                </Link>
                                <Link href="/orders" className="text-gray-600 hover:text-primary-600 transition-colors font-medium">
                                    Orders
                                </Link>
                                <Link href="/cart" className="text-gray-600 hover:text-primary-600 transition-colors font-medium">
                                    Cart
                                </Link>
                                <Link href="/wishlist" className="text-gray-600 hover:text-primary-600 transition-colors font-medium">
                                    Wishlist
                                </Link>
                            </nav>
                        </div>

                        {/* User Info and Actions */}
                        <div className="flex items-center space-x-4">
                            <Link
                                href="/shop"
                                className="hidden sm:inline-flex items-center space-x-2 bg-primary-500 text-white px-4 py-2 rounded-xl hover:bg-primary-600 transition-colors font-medium"
                            >
                                <ShoppingBagIcon className="h-4 w-4" />
                                <span>Continue Shopping</span>
                            </Link>
                            
                            {/* User Menu */}
                            <div className="flex items-center space-x-3">
                                <div className="text-right hidden sm:block">
                                    <p className="text-sm font-medium text-secondary-800">Welcome back,</p>
                                    <p className="text-xs text-gray-600">{user.name}</p>
                                </div>
                                <div className="w-10 h-10 bg-gradient-to-br from-primary-100 to-primary-200 rounded-xl flex items-center justify-center">
                                    <UserIcon className="h-5 w-5 text-primary-600" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Head title="Dashboard - eProShop" />

            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {/* Quick Stats */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        {quickStats.map((stat) => (
                            <Link
                                key={stat.name}
                                href={stat.href}
                                className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow group"
                            >
                                <div className="flex items-center">
                                    <div className={`${stat.color} rounded-xl p-3 flex-shrink-0`}>
                                        <stat.icon className="h-6 w-6 text-white" />
                                    </div>
                                    <div className="ml-4 flex-1">
                                        <p className="text-sm font-medium text-gray-600">{stat.name}</p>
                                        <p className="text-2xl font-bold text-secondary-800">{stat.value}</p>
                                    </div>
                                    <ArrowRightIcon className="h-5 w-5 text-gray-400 group-hover:text-primary-500 transition-colors" />
                                </div>
                            </Link>
                        ))}
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {/* Recent Orders */}
                        <div className="lg:col-span-2">
                            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <div className="flex items-center justify-between mb-6">
                                    <h3 className="text-lg font-semibold text-secondary-800">Recent Orders</h3>
                                    <Link
                                        href="/orders"
                                        className="text-primary-600 hover:text-primary-700 text-sm font-medium flex items-center space-x-1"
                                    >
                                        <span>View All</span>
                                        <ArrowRightIcon className="h-4 w-4" />
                                    </Link>
                                </div>

                                {recentOrders.length > 0 ? (
                                    <div className="space-y-4">
                                        {recentOrders.slice(0, 5).map((order) => (
                                            <div key={order.id} className="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                                <div className="flex items-center space-x-4">
                                                    <div className="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                                        <ShoppingBagIcon className="h-6 w-6 text-primary-600" />
                                                    </div>
                                                    <div>
                                                        <p className="font-medium text-secondary-800">
                                                            Order #{order.order_number || order.id}
                                                        </p>
                                                        <p className="text-sm text-gray-600">
                                                            {order.items_count || 1} item{(order.items_count || 1) !== 1 ? 's' : ''} • ₦{(order.total || 0).toLocaleString()}
                                                        </p>
                                                        <p className="text-xs text-gray-500">
                                                            {new Date(order.created_at).toLocaleDateString()}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div className="flex items-center space-x-3">
                                                    <span className={`px-3 py-1 rounded-full text-xs font-medium ${getOrderStatusColor(order.status)}`}>
                                                        {order.status || 'Pending'}
                                                    </span>
                                                    <Link
                                                        href={`/orders/${order.id}`}
                                                        className="text-gray-400 hover:text-primary-600 transition-colors"
                                                    >
                                                        <EyeIcon className="h-5 w-5" />
                                                    </Link>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <div className="text-center py-12">
                                        <ShoppingBagIcon className="h-16 w-16 text-gray-300 mx-auto mb-4" />
                                        <h4 className="text-lg font-medium text-gray-900 mb-2">No orders yet</h4>
                                        <p className="text-gray-600 mb-6">Start shopping to see your orders here</p>
                                        <Link
                                            href="/shop"
                                            className="inline-flex items-center space-x-2 bg-primary-500 text-white px-6 py-3 rounded-xl hover:bg-primary-600 transition-colors"
                                        >
                                            <ShoppingBagIcon className="h-5 w-5" />
                                            <span>Start Shopping</span>
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* Quick Actions & Account Info */}
                        <div className="space-y-6">
                            {/* Account Summary */}
                            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <h3 className="text-lg font-semibold text-secondary-800 mb-4">Account Summary</h3>
                                <div className="space-y-4">
                                    <div className="flex items-center space-x-3">
                                        <UserIcon className="h-5 w-5 text-gray-400" />
                                        <div>
                                            <p className="text-sm text-gray-600">Name</p>
                                            <p className="font-medium text-secondary-800">{user.name}</p>
                                        </div>
                                    </div>
                                    <div className="flex items-center space-x-3">
                                        <CreditCardIcon className="h-5 w-5 text-gray-400" />
                                        <div>
                                            <p className="text-sm text-gray-600">Email</p>
                                            <p className="font-medium text-secondary-800">{user.email}</p>
                                        </div>
                                    </div>
                                    <div className="flex items-center space-x-3">
                                        <ClockIcon className="h-5 w-5 text-gray-400" />
                                        <div>
                                            <p className="text-sm text-gray-600">Member Since</p>
                                            <p className="font-medium text-secondary-800">
                                                {new Date(user.created_at).toLocaleDateString()}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <Link
                                    href="/profile"
                                    className="w-full mt-4 bg-gray-100 text-gray-700 py-2 px-4 rounded-xl font-medium hover:bg-gray-200 transition-colors text-center block"
                                >
                                    Edit Profile
                                </Link>
                            </div>

                            {/* Quick Actions */}
                            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <h3 className="text-lg font-semibold text-secondary-800 mb-4">Quick Actions</h3>
                                <div className="space-y-3">
                                    <Link
                                        href="/cart"
                                        className="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group"
                                    >
                                        <div className="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                            <ShoppingCartIcon className="h-5 w-5 text-green-600" />
                                        </div>
                                        <div className="flex-1">
                                            <p className="font-medium text-secondary-800">View Cart</p>
                                            <p className="text-sm text-gray-600">{cartCount} items</p>
                                        </div>
                                        <ArrowRightIcon className="h-4 w-4 text-gray-400 group-hover:text-primary-500" />
                                    </Link>

                                    <Link
                                        href="/wishlist"
                                        className="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group"
                                    >
                                        <div className="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                            <HeartIcon className="h-5 w-5 text-red-600" />
                                        </div>
                                        <div className="flex-1">
                                            <p className="font-medium text-secondary-800">Wishlist</p>
                                            <p className="text-sm text-gray-600">{wishlistCount} items</p>
                                        </div>
                                        <ArrowRightIcon className="h-4 w-4 text-gray-400 group-hover:text-primary-500" />
                                    </Link>

                                    <Link
                                        href="/orders"
                                        className="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group"
                                    >
                                        <div className="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                            <TruckIcon className="h-5 w-5 text-blue-600" />
                                        </div>
                                        <div className="flex-1">
                                            <p className="font-medium text-secondary-800">Track Orders</p>
                                            <p className="text-sm text-gray-600">View order status</p>
                                        </div>
                                        <ArrowRightIcon className="h-4 w-4 text-gray-400 group-hover:text-primary-500" />
                                    </Link>

                                    <Link
                                        href="/shop"
                                        className="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group"
                                    >
                                        <div className="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                                            <ShoppingBagIcon className="h-5 w-5 text-primary-600" />
                                        </div>
                                        <div className="flex-1">
                                            <p className="font-medium text-secondary-800">Browse Products</p>
                                            <p className="text-sm text-gray-600">Discover new items</p>
                                        </div>
                                        <ArrowRightIcon className="h-4 w-4 text-gray-400 group-hover:text-primary-500" />
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
