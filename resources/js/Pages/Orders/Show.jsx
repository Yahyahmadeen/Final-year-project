import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, router } from '@inertiajs/react';
import { 
    ShoppingBagIcon,
    ArrowLeftIcon,
    ClockIcon,
    TruckIcon,
    BuildingStorefrontIcon,
    CheckCircleIcon,
    XCircleIcon,
    MapPinIcon,
    CreditCardIcon,
    PhoneIcon,
    UserIcon
} from '@heroicons/react/24/outline';

export default function OrderShow({ order }) {
    const { post, processing } = useForm();

    const handleVerifyPayment = () => {
        post(`/payment/${order.id}/verify`);
    };

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

    const handleCancelOrder = () => {
        if (confirm('Are you sure you want to cancel this order?')) {
            router.post(`/orders/${order.id}/cancel`);
        }
    };

    const StatusIcon = getOrderStatusIcon(order.status);

    return (
        <AuthenticatedLayout
            header={
                <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-4">
                        <Link
                            href="/orders"
                            className="text-gray-600 hover:text-primary-600 transition-colors"
                        >
                            <ArrowLeftIcon className="h-5 w-5" />
                        </Link>
                        <h2 className="text-xl font-semibold leading-tight text-gray-800">
                            Order #{order.order_number || order.id}
                        </h2>
                    </div>
                    {order.status === 'pending' && (
                        <button
                            onClick={handleCancelOrder}
                            className="inline-flex items-center space-x-2 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors"
                        >
                            <XCircleIcon className="h-4 w-4" />
                            <span>Cancel Order</span>
                        </button>
                    )}
                </div>
            }
        >
            <Head title={`Order #${order.order_number || order.id} - eProShop`} />

            <div className="py-8">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {/* Order Details */}
                        <div className="lg:col-span-2 space-y-6">
                            {/* Order Status */}
                            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <div className="flex items-center justify-between mb-6">
                                    <h3 className="text-lg font-semibold text-secondary-800">Order Status</h3>
                                    <div className={`flex items-center space-x-2 px-4 py-2 rounded-xl border ${getOrderStatusColor(order.status)}`}>
                                        <StatusIcon className="h-5 w-5" />
                                        <span className="font-medium capitalize">
                                            {order.status || 'Pending'}
                                        </span>
                                    </div>
                                </div>

                                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <div>
                                        <p className="text-sm text-gray-600 mb-1">Order Date</p>
                                        <p className="font-medium text-secondary-800">
                                            {new Date(order.created_at).toLocaleDateString('en-US', {
                                                year: 'numeric',
                                                month: 'long',
                                                day: 'numeric',
                                                hour: '2-digit',
                                                minute: '2-digit'
                                            })}
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <p className="text-sm text-gray-600 mb-1">Payment Method</p>
                                        <p className="font-medium text-secondary-800 capitalize">
                                            {order.payment_method || 'Not specified'}
                                        </p>
                                    </div>

                                    <div>
                                        <p className="text-sm text-gray-600 mb-1">Payment Status</p>
                                        <div className={`inline-flex items-center space-x-2 px-3 py-1 rounded-lg text-sm font-medium ${
                                            order.payment_status === 'paid' ? 'bg-green-100 text-green-800' :
                                            order.payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                            order.payment_status === 'failed' ? 'bg-red-100 text-red-800' :
                                            order.payment_status === 'cooperative_pending' ? 'bg-orange-100 text-orange-800' :
                                            order.payment_status === 'cooperative_approved' ? 'bg-green-100 text-green-800' :
                                            order.payment_status === 'cooperative_rejected' ? 'bg-red-100 text-red-800' :
                                            'bg-gray-100 text-gray-800'
                                        }`}>
                                            {order.payment_status === 'paid' && <CheckCircleIcon className="h-4 w-4" />}
                                            {order.payment_status === 'pending' && <ClockIcon className="h-4 w-4" />}
                                            {order.payment_status === 'failed' && <XCircleIcon className="h-4 w-4" />}
                                            {order.payment_status?.includes('cooperative') && <BuildingStorefrontIcon className="h-4 w-4" />}
                                            <span className="capitalize">
                                                {order.payment_status === 'cooperative_pending' ? 'Coop Pending' :
                                                 order.payment_status === 'cooperative_approved' ? 'Coop Approved' :
                                                 order.payment_status === 'cooperative_rejected' ? 'Coop Rejected' :
                                                 order.payment_status || 'Unknown'}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {/* Payment Reference */}
                                {order.payment_reference && (
                                    <div className="mt-4 p-4 bg-gray-50 rounded-xl">
                                        <p className="text-sm text-gray-600 mb-1">Payment Reference</p>
                                        <p className="font-mono text-sm text-secondary-800">{order.payment_reference}</p>
                                    </div>
                                )}
                            </div>

                            {/* Order Items */}
                            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <h3 className="text-lg font-semibold text-secondary-800 mb-6">Order Items</h3>
                                
                                <div className="space-y-4">
                                    {order.items?.map((item) => (
                                        <div key={item.id} className="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                                            <div className="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <ShoppingBagIcon className="h-8 w-8 text-gray-400" />
                                            </div>
                                            
                                            <div className="flex-1">
                                                <h4 className="font-medium text-secondary-800 mb-1">
                                                    {item.product?.name || 'Product'}
                                                </h4>
                                                <p className="text-sm text-gray-600 mb-2">
                                                    {item.product?.description && item.product.description.length > 100 
                                                        ? item.product.description.substring(0, 100) + '...'
                                                        : item.product?.description || 'No description available'
                                                    }
                                                </p>
                                                <div className="flex items-center space-x-4 text-sm">
                                                    <span className="text-gray-600">Qty: {item.quantity}</span>
                                                    <span className="text-gray-600">Price: ₦{(item.price || 0).toLocaleString()}</span>
                                                </div>
                                            </div>
                                            
                                            <div className="text-right">
                                                <p className="text-lg font-semibold text-secondary-800">
                                                    ₦{(item.total || 0).toLocaleString()}
                                                </p>
                                            </div>
                                        </div>
                                    ))}
                                </div>

                                {/* Order Total */}
                                <div className="mt-6 pt-6 border-t border-gray-200">
                                    <div className="flex justify-between items-center">
                                        <span className="text-lg font-semibold text-secondary-800">Total Amount</span>
                                        <span className="text-2xl font-bold text-primary-600">
                                            ₦{(order.total_amount || 0).toLocaleString()}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Order Summary & Shipping */}
                        <div className="space-y-6">
                            {/* Order Summary */}
                            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <h3 className="text-lg font-semibold text-secondary-800 mb-4">Order Summary</h3>
                                
                                <div className="space-y-4">
                                    <div className="flex items-center space-x-3">
                                        <ShoppingBagIcon className="h-5 w-5 text-gray-400" />
                                        <div>
                                            <p className="text-sm text-gray-600">Order Number</p>
                                            <p className="font-medium text-secondary-800">
                                                #{order.order_number || order.id}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div className="flex items-center space-x-3">
                                        <ClockIcon className="h-5 w-5 text-gray-400" />
                                        <div>
                                            <p className="text-sm text-gray-600">Items Count</p>
                                            <p className="font-medium text-secondary-800">
                                                {order.items?.length || 0} item{(order.items?.length || 0) !== 1 ? 's' : ''}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div className="flex items-center space-x-3">
                                        <CreditCardIcon className="h-5 w-5 text-gray-400" />
                                        <div>
                                            <p className="text-sm text-gray-600">Total Amount</p>
                                            <p className="font-medium text-secondary-800">
                                                ₦{(order.total_amount || 0).toLocaleString()}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Shipping Address */}
                            {order.shipping_address && (
                                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                    <h3 className="text-lg font-semibold text-secondary-800 mb-4">Shipping Address</h3>
                                    
                                    <div className="space-y-3">
                                        {order.shipping_address.name && (
                                            <div className="flex items-center space-x-3">
                                                <UserIcon className="h-4 w-4 text-gray-400" />
                                                <span className="text-sm text-gray-700">{order.shipping_address.name}</span>
                                            </div>
                                        )}
                                        
                                        {order.shipping_address.phone && (
                                            <div className="flex items-center space-x-3">
                                                <PhoneIcon className="h-4 w-4 text-gray-400" />
                                                <span className="text-sm text-gray-700">{order.shipping_address.phone}</span>
                                            </div>
                                        )}
                                        
                                        {(order.shipping_address.address || order.shipping_address.street) && (
                                            <div className="flex items-start space-x-3">
                                                <MapPinIcon className="h-4 w-4 text-gray-400 mt-0.5" />
                                                <div className="text-sm text-gray-700">
                                                    <p>{order.shipping_address.address || order.shipping_address.street}</p>
                                                    {order.shipping_address.city && (
                                                        <p>{order.shipping_address.city}</p>
                                                    )}
                                                    {order.shipping_address.state && (
                                                        <p>{order.shipping_address.state}</p>
                                                    )}
                                                    {order.shipping_address.postal_code && (
                                                        <p>{order.shipping_address.postal_code}</p>
                                                    )}
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            )}

                            {/* Vendor Information */}
                            {order.vendor && (
                                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                    <h3 className="text-lg font-semibold text-secondary-800 mb-4">Vendor</h3>
                                    
                                    <div className="flex items-center space-x-4">
                                        <div className="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                            <ShoppingBagIcon className="h-6 w-6 text-primary-600" />
                                        </div>
                                        <div>
                                            <p className="font-medium text-secondary-800">
                                                {order.vendor.store_name || order.vendor.name}
                                            </p>
                                            <p className="text-sm text-gray-600">
                                                {order.vendor.email}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            )}

                            {/* Actions */}
                            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <h3 className="text-lg font-semibold text-secondary-800 mb-4">Actions</h3>
                                
                                <div className="space-y-3">
                                    {/* Payment Button - Show for pending Paystack orders */}
                                    {order.status === 'pending' && order.payment_method === 'paystack' && order.payment_status === 'pending' && (
                                        <Link
                                            href={`/payment/paystack/${order.id}`}
                                            className="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 px-4 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-300 text-center block flex items-center justify-center space-x-2"
                                        >
                                            <CreditCardIcon className="h-5 w-5" />
                                            <span>Pay Now - ₦{(order.total_amount || 0).toLocaleString()}</span>
                                        </Link>
                                    )}

                                    {/* Verify Payment Button - Show for processing orders with pending payment */}
                                    {(order.status === 'processing' && order.payment_status === 'pending') && (
                                        <button
                                            onClick={handleVerifyPayment}
                                            disabled={processing}
                                            className="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-4 rounded-xl font-semibold hover:from-blue-600 hover:to-blue-700 transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            <CheckCircleIcon className="h-5 w-5" />
                                            <span>{processing ? 'Verifying...' : 'Verify Payment Status'}</span>
                                        </button>
                                    )}

                                    {/* Bank Transfer Instructions - Show for pending bank transfer orders */}
                                    {order.status === 'pending' && order.payment_method === 'bank_transfer' && order.payment_status === 'pending' && (
                                        <div className="w-full bg-blue-50 border border-blue-200 rounded-xl p-4">
                                            <h4 className="font-semibold text-blue-800 mb-2 flex items-center space-x-2">
                                                <CreditCardIcon className="h-5 w-5" />
                                                <span>Bank Transfer Details</span>
                                            </h4>
                                            <div className="text-sm text-blue-700 space-y-1">
                                                <p><strong>Bank:</strong> First Bank Nigeria</p>
                                                <p><strong>Account Name:</strong> eProShop Marketplace</p>
                                                <p><strong>Account Number:</strong> 1234567890</p>
                                                <p><strong>Amount:</strong> ₦{(order.total_amount || 0).toLocaleString()}</p>
                                                <p><strong>Reference:</strong> {order.order_number}</p>
                                            </div>
                                        </div>
                                    )}

                                    {/* Cooperative Status - Show for cooperative orders */}
                                    {order.payment_method === 'cooperative' && (
                                        <div className={`w-full rounded-xl p-4 ${
                                            order.payment_status === 'cooperative_pending' 
                                                ? 'bg-yellow-50 border border-yellow-200' 
                                                : order.payment_status === 'cooperative_approved'
                                                ? 'bg-green-50 border border-green-200'
                                                : 'bg-red-50 border border-red-200'
                                        }`}>
                                            <h4 className={`font-semibold mb-2 flex items-center space-x-2 ${
                                                order.payment_status === 'cooperative_pending' 
                                                    ? 'text-yellow-800' 
                                                    : order.payment_status === 'cooperative_approved'
                                                    ? 'text-green-800'
                                                    : 'text-red-800'
                                            }`}>
                                                <BuildingStorefrontIcon className="h-5 w-5" />
                                                <span>Cooperative Sponsorship</span>
                                            </h4>
                                            <p className={`text-sm ${
                                                order.payment_status === 'cooperative_pending' 
                                                    ? 'text-yellow-700' 
                                                    : order.payment_status === 'cooperative_approved'
                                                    ? 'text-green-700'
                                                    : 'text-red-700'
                                            }`}>
                                                {order.payment_status === 'cooperative_pending' && 'Your cooperative sponsorship request is pending approval.'}
                                                {order.payment_status === 'cooperative_approved' && 'Your cooperative has approved this sponsorship.'}
                                                {order.payment_status === 'cooperative_rejected' && 'Your cooperative sponsorship request was declined.'}
                                            </p>
                                        </div>
                                    )}
                                    
                                    <Link
                                        href="/orders"
                                        className="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-xl font-medium hover:bg-gray-200 transition-colors text-center block"
                                    >
                                        Back to Orders
                                    </Link>
                                    
                                    <Link
                                        href="/shop"
                                        className="w-full bg-primary-500 text-white py-3 px-4 rounded-xl font-medium hover:bg-primary-600 transition-colors text-center block"
                                    >
                                        Continue Shopping
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
