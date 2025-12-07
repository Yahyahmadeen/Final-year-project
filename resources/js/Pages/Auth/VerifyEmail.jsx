import { Head, Link, useForm } from '@inertiajs/react';
import { 
    ShoppingBagIcon, 
    EnvelopeIcon,
    PaperAirplaneIcon,
    CheckCircleIcon,
    ExclamationTriangleIcon
} from '@heroicons/react/24/outline';

export default function VerifyEmail({ status }) {
    const { post, processing } = useForm({});

    const submit = (e) => {
        e.preventDefault();

        post(route('verification.send'));
    };

    return (
        <div className="min-h-screen bg-gradient-to-br from-primary-50 via-white to-accent-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <Head title="Verify Email - eProShop" />
            
            <div className="max-w-md w-full space-y-8">
                {/* Header */}
                <div className="text-center">
                    <Link href="/" className="inline-flex items-center space-x-2 mb-6">
                        <div className="bg-primary-500 text-white p-3 rounded-2xl">
                            <ShoppingBagIcon className="h-8 w-8" />
                        </div>
                        <div>
                            <h1 className="text-3xl font-bold text-secondary-800">eProShop</h1>
                            <p className="text-sm text-gray-500">Multi-Vendor Marketplace</p>
                        </div>
                    </Link>
                    <h2 className="text-2xl font-bold text-secondary-800 mb-2">Verify Your Email</h2>
                    <p className="text-gray-600">We've sent a verification link to your email address</p>
                </div>

                {/* Status Message */}
                {status === 'verification-link-sent' && (
                    <div className="bg-green-50 border border-green-200 rounded-2xl p-4">
                        <div className="flex items-center">
                            <CheckCircleIcon className="h-5 w-5 text-green-600 mr-2" />
                            <div className="text-sm font-medium text-green-800">
                                A new verification link has been sent to your email address!
                            </div>
                        </div>
                    </div>
                )}

                {/* Verification Form */}
                <div className="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div className="text-center mb-6">
                        <div className="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                            <EnvelopeIcon className="h-8 w-8 text-primary-600" />
                        </div>
                        <h3 className="text-lg font-semibold text-secondary-800 mb-2">Check Your Email</h3>
                        <p className="text-gray-600 text-sm leading-relaxed">
                            Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.
                        </p>
                    </div>

                    {/* Warning Notice */}
                    <div className="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-6">
                        <div className="flex items-start">
                            <ExclamationTriangleIcon className="h-5 w-5 text-amber-600 mr-2 mt-0.5 flex-shrink-0" />
                            <div className="text-sm text-amber-800">
                                <p className="font-medium mb-1">Didn't receive the email?</p>
                                <p>Check your spam folder or click the button below to resend the verification email.</p>
                            </div>
                        </div>
                    </div>

                    <form onSubmit={submit} className="space-y-6">
                        {/* Resend Button */}
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-4 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                        >
                            <PaperAirplaneIcon className="h-5 w-5" />
                            <span>{processing ? 'Sending...' : 'Resend Verification Email'}</span>
                        </button>

                        {/* Divider */}
                        <div className="relative my-6">
                            <div className="absolute inset-0 flex items-center">
                                <div className="w-full border-t border-gray-300"></div>
                            </div>
                            <div className="relative flex justify-center text-sm">
                                <span className="px-2 bg-white text-gray-500">Need to use a different email?</span>
                            </div>
                        </div>

                        {/* Logout Button */}
                        <Link
                            href={route('logout')}
                            method="post"
                            as="button"
                            className="w-full block text-center bg-gray-100 text-gray-700 py-3 px-4 rounded-2xl font-semibold hover:bg-gray-200 transition-colors"
                        >
                            Sign Out & Try Again
                        </Link>
                    </form>

                    {/* Help Text */}
                    <div className="mt-6 text-center">
                        <p className="text-xs text-gray-500">
                            Having trouble? Contact our support team for assistance.
                        </p>
                    </div>
                </div>

                {/* Back to Shop */}
                <div className="text-center">
                    <Link
                        href="/"
                        className="text-sm text-gray-600 hover:text-primary-600 transition-colors"
                    >
                        ← Back to eProShop
                    </Link>
                </div>
            </div>
        </div>
    );
}
