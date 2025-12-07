import { Head, Link, useForm } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    BuildingStorefrontIcon,
    CheckCircleIcon,
    InformationCircleIcon
} from '@heroicons/react/24/outline';
import { useState } from 'react';

export default function VendorRegister() {
    const { data, setData, post, processing, errors } = useForm({
        store_name: '',
        description: '',
        business_type: '',
        phone: '',
        address: '',
        business_registration_number: '',
    });

    const [step, setStep] = useState(1);

    const businessTypes = [
        'Electronics & Technology',
        'Fashion & Clothing',
        'Home & Garden',
        'Sports & Recreation',
        'Books & Education',
        'Automotive',
        'Health & Beauty',
        'Food & Beverages',
        'Arts & Crafts',
        'Other'
    ];

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('vendors.store'));
    };

    const nextStep = () => {
        if (step < 3) setStep(step + 1);
    };

    const prevStep = () => {
        if (step > 1) setStep(step - 1);
    };

    return (
        <AppLayout>
            <Head title="Become a Vendor - eProShop" />
            
            <div className="min-h-screen bg-gray-50">
                {/* Header */}
                <div className="bg-gradient-to-br from-primary-500 via-primary-600 to-secondary-800 text-white">
                    <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                        <div className="text-center">
                            <BuildingStorefrontIcon className="h-16 w-16 mx-auto mb-6 text-accent-400" />
                            <h1 className="text-4xl font-bold mb-4">Become a Vendor</h1>
                            <p className="text-xl text-gray-200 max-w-2xl mx-auto">
                                Join thousands of successful vendors on eProShop and grow your business 
                                with access to customers across Nigeria
                            </p>
                        </div>
                    </div>
                </div>

                {/* Progress Steps */}
                <div className="bg-white shadow-sm">
                    <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                        <div className="flex items-center justify-center">
                            <div className="flex items-center space-x-8">
                                {[1, 2, 3].map((stepNumber) => (
                                    <div key={stepNumber} className="flex items-center">
                                        <div className={`w-10 h-10 rounded-full flex items-center justify-center font-semibold ${
                                            step >= stepNumber 
                                                ? 'bg-primary-500 text-white' 
                                                : 'bg-gray-200 text-gray-600'
                                        }`}>
                                            {step > stepNumber ? (
                                                <CheckCircleIcon className="h-6 w-6" />
                                            ) : (
                                                stepNumber
                                            )}
                                        </div>
                                        <div className="ml-3">
                                            <div className={`text-sm font-medium ${
                                                step >= stepNumber ? 'text-primary-600' : 'text-gray-500'
                                            }`}>
                                                {stepNumber === 1 && 'Basic Info'}
                                                {stepNumber === 2 && 'Business Details'}
                                                {stepNumber === 3 && 'Review & Submit'}
                                            </div>
                                        </div>
                                        {stepNumber < 3 && (
                                            <div className={`w-16 h-1 mx-4 ${
                                                step > stepNumber ? 'bg-primary-500' : 'bg-gray-200'
                                            }`} />
                                        )}
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>

                {/* Form */}
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div className="bg-white rounded-3xl shadow-lg overflow-hidden">
                        <form onSubmit={handleSubmit} className="p-8">
                            {/* Step 1: Basic Information */}
                            {step === 1 && (
                                <div className="space-y-6">
                                    <div className="text-center mb-8">
                                        <h2 className="text-2xl font-bold text-secondary-800 mb-2">Basic Information</h2>
                                        <p className="text-gray-600">Tell us about your store</p>
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Store Name *
                                        </label>
                                        <input
                                            type="text"
                                            value={data.store_name}
                                            onChange={(e) => setData('store_name', e.target.value)}
                                            className="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                            placeholder="Enter your store name"
                                            required
                                        />
                                        {errors.store_name && (
                                            <p className="mt-1 text-sm text-red-600">{errors.store_name}</p>
                                        )}
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Business Type *
                                        </label>
                                        <select
                                            value={data.business_type}
                                            onChange={(e) => setData('business_type', e.target.value)}
                                            className="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                            required
                                        >
                                            <option value="">Select business type</option>
                                            {businessTypes.map((type) => (
                                                <option key={type} value={type}>{type}</option>
                                            ))}
                                        </select>
                                        {errors.business_type && (
                                            <p className="mt-1 text-sm text-red-600">{errors.business_type}</p>
                                        )}
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Store Description *
                                        </label>
                                        <textarea
                                            value={data.description}
                                            onChange={(e) => setData('description', e.target.value)}
                                            rows={4}
                                            className="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                            placeholder="Describe your store and what you sell"
                                            required
                                        />
                                        {errors.description && (
                                            <p className="mt-1 text-sm text-red-600">{errors.description}</p>
                                        )}
                                    </div>
                                </div>
                            )}

                            {/* Step 2: Business Details */}
                            {step === 2 && (
                                <div className="space-y-6">
                                    <div className="text-center mb-8">
                                        <h2 className="text-2xl font-bold text-secondary-800 mb-2">Business Details</h2>
                                        <p className="text-gray-600">Contact and location information</p>
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number *
                                        </label>
                                        <input
                                            type="tel"
                                            value={data.phone}
                                            onChange={(e) => setData('phone', e.target.value)}
                                            className="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                            placeholder="+234 800 123 4567"
                                            required
                                        />
                                        {errors.phone && (
                                            <p className="mt-1 text-sm text-red-600">{errors.phone}</p>
                                        )}
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Business Address *
                                        </label>
                                        <textarea
                                            value={data.address}
                                            onChange={(e) => setData('address', e.target.value)}
                                            rows={3}
                                            className="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                            placeholder="Enter your business address"
                                            required
                                        />
                                        {errors.address && (
                                            <p className="mt-1 text-sm text-red-600">{errors.address}</p>
                                        )}
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Business Registration Number (Optional)
                                        </label>
                                        <input
                                            type="text"
                                            value={data.business_registration_number}
                                            onChange={(e) => setData('business_registration_number', e.target.value)}
                                            className="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                            placeholder="CAC registration number (if available)"
                                        />
                                        {errors.business_registration_number && (
                                            <p className="mt-1 text-sm text-red-600">{errors.business_registration_number}</p>
                                        )}
                                    </div>
                                </div>
                            )}

                            {/* Step 3: Review */}
                            {step === 3 && (
                                <div className="space-y-6">
                                    <div className="text-center mb-8">
                                        <h2 className="text-2xl font-bold text-secondary-800 mb-2">Review Your Information</h2>
                                        <p className="text-gray-600">Please review your details before submitting</p>
                                    </div>

                                    <div className="bg-gray-50 rounded-2xl p-6 space-y-4">
                                        <div>
                                            <h3 className="font-semibold text-gray-700">Store Name</h3>
                                            <p className="text-gray-900">{data.store_name}</p>
                                        </div>
                                        <div>
                                            <h3 className="font-semibold text-gray-700">Business Type</h3>
                                            <p className="text-gray-900">{data.business_type}</p>
                                        </div>
                                        <div>
                                            <h3 className="font-semibold text-gray-700">Description</h3>
                                            <p className="text-gray-900">{data.description}</p>
                                        </div>
                                        <div>
                                            <h3 className="font-semibold text-gray-700">Phone</h3>
                                            <p className="text-gray-900">{data.phone}</p>
                                        </div>
                                        <div>
                                            <h3 className="font-semibold text-gray-700">Address</h3>
                                            <p className="text-gray-900">{data.address}</p>
                                        </div>
                                        {data.business_registration_number && (
                                            <div>
                                                <h3 className="font-semibold text-gray-700">Registration Number</h3>
                                                <p className="text-gray-900">{data.business_registration_number}</p>
                                            </div>
                                        )}
                                    </div>

                                    <div className="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                                        <div className="flex items-start">
                                            <InformationCircleIcon className="h-6 w-6 text-blue-600 mt-0.5 mr-3" />
                                            <div>
                                                <h4 className="text-blue-800 font-semibold mb-1">Application Review</h4>
                                                <p className="text-blue-700 text-sm">
                                                    Your vendor application will be reviewed by our team within 2-3 business days. 
                                                    You'll receive an email notification once your application is approved.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            )}

                            {/* Navigation Buttons */}
                            <div className="flex justify-between mt-8 pt-6 border-t border-gray-200">
                                <div>
                                    {step > 1 && (
                                        <button
                                            type="button"
                                            onClick={prevStep}
                                            className="px-6 py-3 border border-gray-300 text-gray-700 rounded-2xl hover:bg-gray-50 transition-colors"
                                        >
                                            Previous
                                        </button>
                                    )}
                                </div>

                                <div className="flex space-x-4">
                                    <Link
                                        href="/vendors"
                                        className="px-6 py-3 text-gray-600 hover:text-gray-800 transition-colors"
                                    >
                                        Cancel
                                    </Link>
                                    
                                    {step < 3 ? (
                                        <button
                                            type="button"
                                            onClick={nextStep}
                                            className="px-8 py-3 bg-primary-500 text-white rounded-2xl hover:bg-primary-600 transition-colors"
                                        >
                                            Next
                                        </button>
                                    ) : (
                                        <button
                                            type="submit"
                                            disabled={processing}
                                            className="px-8 py-3 bg-primary-500 text-white rounded-2xl hover:bg-primary-600 transition-colors disabled:opacity-50"
                                        >
                                            {processing ? 'Submitting...' : 'Submit Application'}
                                        </button>
                                    )}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {/* Benefits Section */}
                <div className="bg-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                        <div className="text-center mb-12">
                            <h2 className="text-3xl font-bold text-secondary-800 mb-4">Why Sell on eProShop?</h2>
                            <p className="text-gray-600">Join a platform designed for Nigerian businesses</p>
                        </div>
                        
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div className="text-center">
                                <div className="bg-primary-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <BuildingStorefrontIcon className="h-8 w-8 text-primary-600" />
                                </div>
                                <h3 className="text-xl font-semibold text-secondary-800 mb-2">Easy Setup</h3>
                                <p className="text-gray-600">Get your store online in minutes with our simple setup process</p>
                            </div>
                            <div className="text-center">
                                <div className="bg-accent-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <CheckCircleIcon className="h-8 w-8 text-accent-600" />
                                </div>
                                <h3 className="text-xl font-semibold text-secondary-800 mb-2">Trusted Platform</h3>
                                <p className="text-gray-600">Benefit from our reputation and customer trust across Nigeria</p>
                            </div>
                            <div className="text-center">
                                <div className="bg-secondary-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <InformationCircleIcon className="h-8 w-8 text-secondary-600" />
                                </div>
                                <h3 className="text-xl font-semibold text-secondary-800 mb-2">Full Support</h3>
                                <p className="text-gray-600">Get dedicated support to help grow your business</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
