import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { 
    ShoppingBagIcon,
    EyeIcon,
    ClockIcon,
    TruckIcon,
    CheckCircleIcon,
    XCircleIcon,
    ArrowLeftIcon,
    CreditCardIcon,
    ExclamationTriangleIcon,
    BuildingStorefrontIcon
} from '@heroicons/react/24/outline';

export default function OrdersIndex({ orders }) {
    const getOrderStatusColor = (status) => {
        switch (status?.toLowerCase()) {
            case 'pending': return 'bg-yellow-100 text-yellow-800 border-yellow-200';
            case 'processing': return 'bg-blue-100 text-blue-800 border-blue-200';
            case 'shipped': return 'bg-indigo-100 text-indigo-800 border-indigo-200';
            case 'delivered': return 'bg-green-100 text-green-800 border-green-200';
            case 'cancelled': return 'bg-red-100 text-red-800 border-red-200';
            default: return 'bg-gray-100 text-gray-800 border-gray-200';
        }
    };

    const getOrderStatusIcon = (status) => {
        switch (status?.toLowerCase()) {
            case 'pending': return ClockIcon;
            case 'processing': return ShoppingBagIcon;
            case 'shipped': return TruckIcon;
            case 'delivered': return CheckCircleIcon;
            case 'cancelled': return XCircleIcon;
            default: return ClockIcon;
        }
    };

    const getPaymentStatusColor = (paymentStatus) => {
        switch (paymentStatus?.toLowerCase()) {
            case 'pending': return 'bg-yellow-100 text-yellow-800 border-yellow-200';
            case 'paid': return 'bg-green-100 text-green-800 border-green-200';
            case 'failed': return 'bg-red-100 text-red-800 border-red-200';
            case 'refunded': return 'bg-gray-100 text-gray-800 border-gray-200';
            case 'cooperative_pending': return 'bg-orange-100 text-orange-800 border-orange-200';
            case 'cooperative_approved': return 'bg-green-100 text-green-800 border-green-200';
            case 'cooperative_rejected': return 'bg-red-100 text-red-800 border-red-200';
            default: return 'bg-gray-100 text-gray-800 border-gray-200';
        }
    };

    const getPaymentStatusIcon = (paymentStatus) => {
        switch (paymentStatus?.toLowerCase()) {
            case 'pending': return ClockIcon;
            case 'paid': return CheckCircleIcon;
            case 'failed': return XCircleIcon;
            case 'refunded': return ExclamationTriangleIcon;
            case 'cooperative_pending': return BuildingStorefrontIcon;
            case 'cooperative_approved': return CheckCircleIcon;
            case 'cooperative_rejected': return XCircleIcon;
            default: return CreditCardIcon;
        }
    };

    const getPaymentStatusText = (paymentStatus) => {
        switch (paymentStatus?.toLowerCase()) {
            case 'pending': return 'Payment Pending';
            case 'paid': return 'Paid';
            case 'failed': return 'Payment Failed';
            case 'refunded': return 'Refunded';
            case 'cooperative_pending': return 'Coop Pending';
            case 'cooperative_approved': return 'Coop Approved';
            case 'cooperative_rejected': return 'Coop Rejected';
            default: return 'Unknown';
        }
    };

    return (
        <AuthenticatedLayout
            header={
                <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-4">
                        <Link
                            href="/dashboard"
                            className="text-gray-600 hover:text-primary-600 transition-colors"
                        >
                            <ArrowLeftIcon className="h-5 w-5" />
                        </Link>
                        <h2 className="text-xl font-semibold leading-tight text-gray-800">
                            My Orders
                        </h2>
                    </div>
                    <Link
                        href="/shop"
                        className="inline-flex items-center space-x-2 bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition-colors"
                    >
                        <ShoppingBagIcon className="h-4 w-4" />
                        <span>Continue Shopping</span>
                    </Link>
                </div>
            }
        >
            <Head title="My Orders - eProShop" />

            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {orders.data.length > 0 ? (
                        <div className="space-y-6">
                            {orders.data.map((order) => {
                                const StatusIcon = getOrderStatusIcon(order.status);
                                const PaymentIcon = getPaymentStatusIcon(order.payment_status);
                                
                                return (
                                    <div key={order.id} className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                        {/* Order Header */}
                                        <div className="p-6 border-b border-gray-100">
                                            <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                                                <div className="flex items-center space-x-4">
                                                    <div className="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                                        <ShoppingBagIcon className="h-6 w-6 text-primary-600" />
                                                    </div>
                                                    <div>
                                                        <h3 className="text-lg font-semibold text-secondary-800">
                                                            Order #{order.order_number || order.id}
                                                        </h3>
                                                        <p className="text-sm text-gray-600">
                                                            Placed on {new Date(order.created_at).toLocaleDateString('en-US', {
                                                                year: 'numeric',
                                                                month: 'long',
                                                                day: 'numeric'
                                                            })}
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <div className="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                                                    {/* Order Status */}
                                                    <div className={`flex items-center space-x-2 px-3 py-2 rounded-xl border ${getOrderStatusColor(order.status)}`}>
                                                        <StatusIcon className="h-4 w-4" />
                                                        <span className="text-sm font-medium capitalize">
                                                            {order.status || 'Pending'}
                                                        </span>
                                                    </div>
                                                    
                                                    {/* Payment Status */}
                                                    <div className={`flex items-center space-x-2 px-3 py-2 rounded-xl border ${getPaymentStatusColor(order.payment_status)}`}>
                                                        <PaymentIcon className="h-4 w-4" />
                                                        <span className="text-sm font-medium">
                                                            {getPaymentStatusText(order.payment_status)}
                                                        </span>
                                                    </div>
                                                    
                                                    <Link
                                                        href={`/orders/${order.id}`}
                                                        className="inline-flex items-center space-x-2 text-primary-600 hover:text-primary-700 transition-colors"
                                                    >
                                                        <EyeIcon className="h-4 w-4" />
                                                        <span className="text-sm font-medium">View Details</span>
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Order Summary */}
                                        <div className="p-6">
                                            <div className="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                                <div>
                                                    <p className="text-sm text-gray-600 mb-1">Items</p>
                                                    <p className="text-lg font-semibold text-secondary-800">
                                                        {order.items_count || order.items?.length || 0} item{(order.items_count || order.items?.length || 0) !== 1 ? 's' : ''}
                                                    </p>
                                                </div>
                                                
                                                <div>
                                                    <p className="text-sm text-gray-600 mb-1">Total Amount</p>
                                                    <p className="text-lg font-semibold text-secondary-800">
                                                        ₦{(order.total_amount || 0).toLocaleString()}
                                                    </p>
                                                </div>
                                                
                                                <div>
                                                    <p className="text-sm text-gray-600 mb-1">Payment Method</p>
                                                    <p className="text-lg font-semibold text-secondary-800 capitalize">
                                                        {order.payment_method || 'Not specified'}
                                                    </p>
                                                </div>
                                            </div>

                                            {/* Order Items Preview */}
                                            {order.items && order.items.length > 0 && (
                                                <div className="mt-6 pt-6 border-t border-gray-100">
                                                    <h4 className="text-sm font-medium text-gray-700 mb-4">Order Items</h4>
                                                    <div className="space-y-3">
                                                        {order.items.slice(0, 3).map((item) => (
                                                            <div key={item.id} className="flex items-center space-x-4">
                                                                <div className="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                                                    <ShoppingBagIcon className="h-6 w-6 text-gray-400" />
                                                                </div>
                                                                <div className="flex-1">
                                                                    <p className="font-medium text-secondary-800">
                                                                        {item.product?.name || 'Product'}
                                                                    </p>
                                                                    <p className="text-sm text-gray-600">
                                                                        Qty: {item.quantity} × ₦{(item.price || 0).toLocaleString()}
                                                                    </p>
                                                                </div>
                                                                <p className="font-semibold text-secondary-800">
                                                                    ₦{(item.total || 0).toLocaleString()}
                                                                </p>
                                                            </div>
                                                        ))}
                                                        
                                                        {order.items.length > 3 && (
                                                            <p className="text-sm text-gray-600 text-center py-2">
                                                                +{order.items.length - 3} more item{order.items.length - 3 !== 1 ? 's' : ''}
                                                            </p>
                                                        )}
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                );
                            })}

                            {/* Pagination */}
                            {orders.links && orders.links.length > 3 && (
                                <div className="flex justify-center mt-8">
                                    <nav className="flex items-center space-x-2">
                                        {orders.links.map((link, index) => (
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
                    ) : (
                        <div className="text-center py-16">
                            <div className="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 max-w-md mx-auto">
                                <ShoppingBagIcon className="h-24 w-24 text-gray-300 mx-auto mb-6" />
                                <h2 className="text-2xl font-bold text-secondary-800 mb-4">No orders yet</h2>
                                <p className="text-gray-600 mb-8">
                                    You haven't placed any orders yet. Start shopping to see your orders here.
                                </p>
                                <Link
                                    href="/shop"
                                    className="inline-flex items-center space-x-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-6 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300"
                                >
                                    <ShoppingBagIcon className="h-5 w-5" />
                                    <span>Start Shopping</span>
                                </Link>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
