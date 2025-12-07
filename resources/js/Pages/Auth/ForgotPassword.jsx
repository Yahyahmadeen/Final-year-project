import { Head, Link, useForm } from '@inertiajs/react';
import { 
    ShoppingBagIcon, 
    EnvelopeIcon,
    ArrowLeftIcon,
    PaperAirplaneIcon
} from '@heroicons/react/24/outline';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('password.email'));
    };

    return (
        <div className="min-h-screen flex">
            <Head title="Forgot Password - eProShop" />
            
            {/* Left Side - Background Image */}
            <div className="hidden lg:flex lg:w-1/2 relative">
                <div 
                    className="absolute inset-0 bg-cover bg-center bg-no-repeat"
                    style={{
                        backgroundImage: `url('https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80')`
                    }}
                >
                    <div className="absolute inset-0 bg-gradient-to-br from-primary-600/90 to-secondary-800/90"></div>
                </div>
                <div className="relative z-10 flex flex-col justify-center px-12 text-white">
                    <div className="mb-8">
                        <Link href="/" className="inline-flex items-center space-x-3 mb-8">
                            <div className="bg-white/20 backdrop-blur-sm text-white p-4 rounded-2xl">
                                <ShoppingBagIcon className="h-10 w-10" />
                            </div>
                            <div>
                                <h1 className="text-4xl font-bold">eProShop</h1>
                                <p className="text-white/80">Multi-Vendor Marketplace</p>
                            </div>
                        </Link>
                    </div>
                    <div className="space-y-6">
                        <h2 className="text-4xl font-bold leading-tight">
                            Secure account recovery
                        </h2>
                        <p className="text-xl text-white/90 leading-relaxed">
                            Don't worry, it happens to the best of us. We'll help you get back into your account quickly and securely.
                        </p>
                        <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-6 space-y-3">
                            <h3 className="text-lg font-semibold">What happens next?</h3>
                            <div className="space-y-2 text-white/90">
                                <p>1. Enter your email address</p>
                                <p>2. Check your inbox for reset link</p>
                                <p>3. Create a new secure password</p>
                                <p>4. Sign in with your new password</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* Right Side - Reset Form */}
            <div className="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
                <div className="max-w-md w-full space-y-8">
                    {/* Mobile Header */}
                    <div className="text-center lg:hidden">
                        <Link href="/" className="inline-flex items-center space-x-2 mb-6">
                            <div className="bg-primary-500 text-white p-3 rounded-2xl">
                                <ShoppingBagIcon className="h-8 w-8" />
                            </div>
                            <div>
                                <h1 className="text-3xl font-bold text-secondary-800">eProShop</h1>
                                <p className="text-sm text-gray-500">Multi-Vendor Marketplace</p>
                            </div>
                        </Link>
                    </div>
                    
                    {/* Header */}
                    <div className="text-center">
                        <h2 className="text-3xl font-bold text-secondary-800 mb-2">Forgot Password?</h2>
                        <p className="text-gray-600">No worries! Enter your email and we'll send you a reset link</p>
                    </div>

                {/* Status Message */}
                {status && (
                    <div className="bg-green-50 border border-green-200 rounded-2xl p-4">
                        <div className="flex items-center">
                            <PaperAirplaneIcon className="h-5 w-5 text-green-600 mr-2" />
                            <div className="text-sm font-medium text-green-800">
                                {status}
                            </div>
                        </div>
                    </div>
                )}

                {/* Reset Form */}
                <div className="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div className="text-center mb-6">
                        <div className="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                            <EnvelopeIcon className="h-8 w-8 text-primary-600" />
                        </div>
                        <p className="text-gray-600 text-sm">
                            Enter your email address and we'll send you a password reset link
                        </p>
                    </div>

                    <form onSubmit={submit} className="space-y-6">
                        {/* Email Field */}
                        <div>
                            <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <div className="relative">
                                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <EnvelopeIcon className="h-5 w-5 text-gray-400" />
                                </div>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                                    placeholder="Enter your email address"
                                    autoComplete="email"
                                    required
                                />
                            </div>
                            {errors.email && (
                                <p className="mt-2 text-sm text-red-600">{errors.email}</p>
                            )}
                        </div>

                        {/* Submit Button */}
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-4 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                        >
                            <PaperAirplaneIcon className="h-5 w-5" />
                            <span>{processing ? 'Sending Reset Link...' : 'Send Reset Link'}</span>
                        </button>

                        {/* Back to Login */}
                        <div className="text-center">
                            <Link
                                href={route('login')}
                                className="inline-flex items-center text-sm text-gray-600 hover:text-primary-600 transition-colors"
                            >
                                <ArrowLeftIcon className="h-4 w-4 mr-1" />
                                Back to Sign In
                            </Link>
                        </div>
                    </form>
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
        </div>
    );
}
