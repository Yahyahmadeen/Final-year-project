import { Head, Link } from '@inertiajs/react';
import { 
    ArrowLeftIcon,
    CreditCardIcon,
    ShieldCheckIcon,
    CheckCircleIcon
} from '@heroicons/react/24/outline';
import { useEffect } from 'react';

export default function PaystackPayment({ order, paystackPublicKey, user }) {
    useEffect(() => {
        // Load Paystack script
        const script = document.createElement('script');
        script.src = 'https://js.paystack.co/v1/inline.js';
        script.async = true;
        document.body.appendChild(script);

        return () => {
            document.body.removeChild(script);
        };
    }, []);

    const handlePayment = () => {
        if (!window.PaystackPop) {
            alert('Paystack is not loaded. Please refresh and try again.');
            return;
        }

        const handler = window.PaystackPop.setup({
            key: paystackPublicKey,
            email: user.email,
            amount: Math.round(order.total_amount * 100), // Convert to kobo
            currency: 'NGN',
            ref: `${order.order_number}_${Date.now()}`,
            metadata: {
                order_id: order.id,
                order_number: order.order_number,
                customer_name: user.name,
            },
            callback: function(response) {
                // Payment successful
                window.location.href = `/payment/paystack/${order.id}/callback?reference=${response.reference}`;
            },
            onClose: function() {
                // Payment cancelled
                window.location.href = `/payment/paystack/${order.id}/cancel`;
            }
        });

        handler.openIframe();
    };

    return (
        <div className="min-h-screen bg-gray-50">
            {/* Header */}
            <div className="bg-white shadow-sm border-b border-gray-200">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between h-16">
                        <div className="flex items-center space-x-4">
                            <Link
                                href={`/orders/${order.id}`}
                                className="text-gray-600 hover:text-primary-600 transition-colors"
                            >
                                <ArrowLeftIcon className="h-5 w-5" />
                            </Link>
                            <div className="flex items-center space-x-3">
                                <div className="w-8 h-8 flex items-center justify-center">
                                    <img 
                                        src="/real_logo_eProShop-removebg-preview.png" 
                                        alt="eProShop Logo" 
                                        className="w-8 h-8 object-contain"
                                    />
                                </div>
                                <h1 className="text-xl font-bold text-secondary-800">Payment</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Head title={`Payment - Order #${order.order_number} - eProShop`} />

            <div className="py-8">
                <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
                    {/* Payment Card */}
                    <div className="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
                        {/* Header */}
                        <div className="bg-gradient-to-r from-primary-500 to-primary-600 p-8 text-white">
                            <div className="flex items-center justify-center mb-4">
                                <div className="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                                    <CreditCardIcon className="h-8 w-8 text-white" />
                                </div>
                            </div>
                            <h2 className="text-2xl font-bold text-center mb-2">Secure Payment</h2>
                            <p className="text-center text-primary-100">
                                Complete your payment with Paystack
                            </p>
                        </div>

                        {/* Order Summary */}
                        <div className="p-8">
                            <div className="mb-8">
                                <h3 className="text-lg font-semibold text-secondary-800 mb-4">Order Summary</h3>
                                
                                <div className="bg-gray-50 rounded-2xl p-6 space-y-4">
                                    <div className="flex justify-between items-center">
                                        <span className="text-gray-600">Order Number</span>
                                        <span className="font-medium text-secondary-800">#{order.order_number}</span>
                                    </div>
                                    
                                    <div className="flex justify-between items-center">
                                        <span className="text-gray-600">Items</span>
                                        <span className="font-medium text-secondary-800">
                                            {order.items?.length || 0} item{(order.items?.length || 0) !== 1 ? 's' : ''}
                                        </span>
                                    </div>
                                    
                                    <div className="flex justify-between items-center">
                                        <span className="text-gray-600">Subtotal</span>
                                        <span className="font-medium text-secondary-800">₦{(order.subtotal || 0).toLocaleString()}</span>
                                    </div>
                                    
                                    <div className="flex justify-between items-center">
                                        <span className="text-gray-600">Shipping</span>
                                        <span className="font-medium text-secondary-800">₦{(order.shipping_amount || 0).toLocaleString()}</span>
                                    </div>
                                    
                                    <div className="flex justify-between items-center">
                                        <span className="text-gray-600">Tax</span>
                                        <span className="font-medium text-secondary-800">₦{(order.tax_amount || 0).toLocaleString()}</span>
                                    </div>
                                    
                                    <div className="border-t border-gray-200 pt-4">
                                        <div className="flex justify-between items-center">
                                            <span className="text-lg font-semibold text-secondary-800">Total</span>
                                            <span className="text-2xl font-bold text-primary-600">₦{(order.total_amount || 0).toLocaleString()}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Payment Button */}
                            <button
                                onClick={handlePayment}
                                className="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-4 px-6 rounded-2xl font-bold text-lg hover:from-green-600 hover:to-green-700 focus:ring-4 focus:ring-green-200 transition-all duration-300 flex items-center justify-center space-x-3"
                            >
                                <CreditCardIcon className="h-6 w-6" />
                                <span>Pay ₦{(order.total_amount || 0).toLocaleString()} with Paystack</span>
                            </button>

                            {/* Security Notice */}
                            <div className="mt-6 flex items-center justify-center space-x-2 text-sm text-gray-600">
                                <ShieldCheckIcon className="h-5 w-5 text-green-500" />
                                <span>Your payment is secured by Paystack SSL encryption</span>
                            </div>

                            {/* Payment Methods */}
                            <div className="mt-8 text-center">
                                <p className="text-sm text-gray-600 mb-4">Accepted Payment Methods</p>
                                <div className="flex items-center justify-center space-x-4">
                                    <div className="bg-gray-100 rounded-lg px-3 py-2">
                                        <span className="text-xs font-medium text-gray-700">VISA</span>
                                    </div>
                                    <div className="bg-gray-100 rounded-lg px-3 py-2">
                                        <span className="text-xs font-medium text-gray-700">MASTERCARD</span>
                                    </div>
                                    <div className="bg-gray-100 rounded-lg px-3 py-2">
                                        <span className="text-xs font-medium text-gray-700">VERVE</span>
                                    </div>
                                    <div className="bg-gray-100 rounded-lg px-3 py-2">
                                        <span className="text-xs font-medium text-gray-700">BANK TRANSFER</span>
                                    </div>
                                </div>
                            </div>

                            {/* Support */}
                            <div className="mt-8 text-center">
                                <p className="text-sm text-gray-600">
                                    Need help? Contact our support team at{' '}
                                    <a href="mailto:support@eProShop.com" className="text-primary-600 hover:text-primary-700">
                                        support@eProShop.com
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    {/* Back to Order */}
                    <div className="mt-6 text-center">
                        <Link
                            href={`/orders/${order.id}`}
                            className="inline-flex items-center space-x-2 text-gray-600 hover:text-primary-600 transition-colors"
                        >
                            <ArrowLeftIcon className="h-4 w-4" />
                            <span>Back to Order Details</span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    );
}
