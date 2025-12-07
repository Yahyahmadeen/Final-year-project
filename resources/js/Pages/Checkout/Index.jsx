import { Head, Link, useForm } from '@inertiajs/react';
import { 
    ShoppingBagIcon,
    ArrowLeftIcon,
    CreditCardIcon,
    TruckIcon,
    MapPinIcon,
    PhoneIcon,
    UserIcon,
    BuildingStorefrontIcon,
    CheckCircleIcon
} from '@heroicons/react/24/outline';
import { useState } from 'react';

export default function CheckoutIndex({ cartItems, summary, user }) {
    const [selectedPaymentMethod, setSelectedPaymentMethod] = useState('paystack');
    
    const { data, setData, post, processing, errors } = useForm({
        shipping_address: {
            name: user.name || '',
            phone: '',
            address: '',
            city: '',
            state: '',
            postal_code: '',
        },
        payment_method: 'paystack',
        cooperative_id: null,
        notes: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/checkout');
    };

    const paymentMethods = [
        {
            id: 'paystack',
            name: 'Card Payment',
            description: 'Pay securely with your debit/credit card',
            icon: CreditCardIcon,
            color: 'bg-blue-500',
        },
        {
            id: 'cooperative',
            name: 'Cooperative Sponsorship',
            description: 'Request cooperative to sponsor this purchase',
            icon: BuildingStorefrontIcon,
            color: 'bg-green-500',
        },
        {
            id: 'bank_transfer',
            name: 'Bank Transfer',
            description: 'Pay via direct bank transfer',
            icon: CheckCircleIcon,
            color: 'bg-purple-500',
        },
    ];

    return (
        <div className="min-h-screen bg-gray-50">
            {/* Header */}
            <div className="bg-white shadow-sm border-b border-gray-200">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between h-16">
                        <div className="flex items-center space-x-4">
                            <Link
                                href="/cart"
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
                                <h1 className="text-xl font-bold text-secondary-800">Checkout</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Head title="Checkout - eProShop" />

            <div className="py-8">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <form onSubmit={handleSubmit}>
                        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            {/* Checkout Form */}
                            <div className="lg:col-span-2 space-y-6">
                                {/* Shipping Address */}
                                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                    <div className="flex items-center space-x-3 mb-6">
                                        <div className="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                            <TruckIcon className="h-5 w-5 text-blue-600" />
                                        </div>
                                        <h2 className="text-lg font-semibold text-secondary-800">Shipping Address</h2>
                                    </div>

                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Full Name
                                            </label>
                                            <input
                                                type="text"
                                                value={data.shipping_address.name}
                                                onChange={(e) => setData('shipping_address', {
                                                    ...data.shipping_address,
                                                    name: e.target.value
                                                })}
                                                className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                                required
                                            />
                                            {errors['shipping_address.name'] && (
                                                <p className="text-red-500 text-sm mt-1">{errors['shipping_address.name']}</p>
                                            )}
                                        </div>

                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Phone Number
                                            </label>
                                            <input
                                                type="tel"
                                                value={data.shipping_address.phone}
                                                onChange={(e) => setData('shipping_address', {
                                                    ...data.shipping_address,
                                                    phone: e.target.value
                                                })}
                                                className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                                required
                                            />
                                            {errors['shipping_address.phone'] && (
                                                <p className="text-red-500 text-sm mt-1">{errors['shipping_address.phone']}</p>
                                            )}
                                        </div>

                                        <div className="sm:col-span-2">
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Street Address
                                            </label>
                                            <textarea
                                                value={data.shipping_address.address}
                                                onChange={(e) => setData('shipping_address', {
                                                    ...data.shipping_address,
                                                    address: e.target.value
                                                })}
                                                rows={3}
                                                className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                                required
                                            />
                                            {errors['shipping_address.address'] && (
                                                <p className="text-red-500 text-sm mt-1">{errors['shipping_address.address']}</p>
                                            )}
                                        </div>

                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                City
                                            </label>
                                            <input
                                                type="text"
                                                value={data.shipping_address.city}
                                                onChange={(e) => setData('shipping_address', {
                                                    ...data.shipping_address,
                                                    city: e.target.value
                                                })}
                                                className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                                required
                                            />
                                            {errors['shipping_address.city'] && (
                                                <p className="text-red-500 text-sm mt-1">{errors['shipping_address.city']}</p>
                                            )}
                                        </div>

                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                State
                                            </label>
                                            <input
                                                type="text"
                                                value={data.shipping_address.state}
                                                onChange={(e) => setData('shipping_address', {
                                                    ...data.shipping_address,
                                                    state: e.target.value
                                                })}
                                                className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                                required
                                            />
                                            {errors['shipping_address.state'] && (
                                                <p className="text-red-500 text-sm mt-1">{errors['shipping_address.state']}</p>
                                            )}
                                        </div>
                                    </div>
                                </div>

                                {/* Payment Method */}
                                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                    <div className="flex items-center space-x-3 mb-6">
                                        <div className="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                            <CreditCardIcon className="h-5 w-5 text-green-600" />
                                        </div>
                                        <h2 className="text-lg font-semibold text-secondary-800">Payment Method</h2>
                                    </div>

                                    <div className="space-y-4">
                                        {paymentMethods.map((method) => {
                                            const IconComponent = method.icon;
                                            return (
                                                <label
                                                    key={method.id}
                                                    className={`flex items-center p-4 border-2 rounded-xl cursor-pointer transition-colors ${
                                                        data.payment_method === method.id
                                                            ? 'border-primary-500 bg-primary-50'
                                                            : 'border-gray-200 hover:border-gray-300'
                                                    }`}
                                                >
                                                    <input
                                                        type="radio"
                                                        name="payment_method"
                                                        value={method.id}
                                                        checked={data.payment_method === method.id}
                                                        onChange={(e) => setData('payment_method', e.target.value)}
                                                        className="sr-only"
                                                    />
                                                    <div className={`w-10 h-10 ${method.color} rounded-xl flex items-center justify-center mr-4`}>
                                                        <IconComponent className="h-5 w-5 text-white" />
                                                    </div>
                                                    <div>
                                                        <p className="font-medium text-secondary-800">{method.name}</p>
                                                        <p className="text-sm text-gray-600">{method.description}</p>
                                                    </div>
                                                </label>
                                            );
                                        })}
                                    </div>
                                </div>

                                {/* Order Notes */}
                                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                    <h3 className="text-lg font-semibold text-secondary-800 mb-4">Order Notes (Optional)</h3>
                                    <textarea
                                        value={data.notes}
                                        onChange={(e) => setData('notes', e.target.value)}
                                        placeholder="Any special instructions for your order..."
                                        rows={4}
                                        className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    />
                                </div>
                            </div>

                            {/* Order Summary */}
                            <div className="space-y-6">
                                {/* Cart Items */}
                                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                    <h3 className="text-lg font-semibold text-secondary-800 mb-4">Order Summary</h3>
                                    
                                    <div className="space-y-4 mb-6">
                                        {cartItems.map((item) => (
                                            <div key={item.id} className="flex items-center space-x-4">
                                                <div className="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                                    <ShoppingBagIcon className="h-6 w-6 text-gray-400" />
                                                </div>
                                                <div className="flex-1">
                                                    <p className="font-medium text-secondary-800 text-sm">
                                                        {item.product.name}
                                                    </p>
                                                    <p className="text-xs text-gray-600">
                                                        Qty: {item.quantity} × ₦{(item.product.sale_price || item.product.price).toLocaleString()}
                                                    </p>
                                                </div>
                                                <p className="font-semibold text-secondary-800">
                                                    ₦{(item.quantity * (item.product.sale_price || item.product.price)).toLocaleString()}
                                                </p>
                                            </div>
                                        ))}
                                    </div>

                                    {/* Price Breakdown */}
                                    <div className="border-t border-gray-200 pt-4 space-y-3">
                                        <div className="flex justify-between text-sm">
                                            <span className="text-gray-600">Subtotal</span>
                                            <span className="text-secondary-800">₦{summary.subtotal.toLocaleString()}</span>
                                        </div>
                                        <div className="flex justify-between text-sm">
                                            <span className="text-gray-600">Shipping</span>
                                            <span className="text-secondary-800">₦{summary.shipping.toLocaleString()}</span>
                                        </div>
                                        <div className="flex justify-between text-sm">
                                            <span className="text-gray-600">Tax (7.5%)</span>
                                            <span className="text-secondary-800">₦{summary.tax.toLocaleString()}</span>
                                        </div>
                                        <div className="flex justify-between text-lg font-bold border-t border-gray-200 pt-3">
                                            <span className="text-secondary-800">Total</span>
                                            <span className="text-primary-600">₦{summary.total.toLocaleString()}</span>
                                        </div>
                                    </div>
                                </div>

                                {/* Place Order Button */}
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-4 px-6 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    {processing ? 'Processing...' : `Place Order - ₦${summary.total.toLocaleString()}`}
                                </button>

                                {/* Security Notice */}
                                <div className="bg-gray-50 rounded-xl p-4">
                                    <div className="flex items-center space-x-2 text-sm text-gray-600">
                                        <CheckCircleIcon className="h-4 w-4 text-green-500" />
                                        <span>Your payment information is secure and encrypted</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
