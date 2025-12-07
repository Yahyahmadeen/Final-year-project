import { Head, Link, useForm } from '@inertiajs/react';
import { 
    ShoppingBagIcon, 
    EyeIcon, 
    EyeSlashIcon,
    EnvelopeIcon,
    LockClosedIcon
} from '@heroicons/react/24/outline';
import { useState } from 'react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const [showPassword, setShowPassword] = useState(false);

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <div className="min-h-screen flex">
            <Head title="Login - eProShop" />
            
            {/* Left Side - Background Image */}
            <div className="hidden lg:flex lg:w-1/2 relative">
                <div 
                    className="absolute inset-0 bg-cover bg-center bg-no-repeat"
                    style={{
                        backgroundImage: `url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80')`
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
                            Shop from trusted vendors worldwide
                        </h2>
                        <p className="text-xl text-white/90 leading-relaxed">
                            Discover amazing products from verified vendors. Join thousands of satisfied customers who trust eProShop for their shopping needs.
                        </p>
                        <div className="flex items-center space-x-8 pt-4">
                            <div className="text-center">
                                <div className="text-2xl font-bold">1000+</div>
                                <div className="text-white/80 text-sm">Vendors</div>
                            </div>
                            <div className="text-center">
                                <div className="text-2xl font-bold">50K+</div>
                                <div className="text-white/80 text-sm">Products</div>
                            </div>
                            <div className="text-center">
                                <div className="text-2xl font-bold">100K+</div>
                                <div className="text-white/80 text-sm">Happy Customers</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* Right Side - Login Form */}
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
                        <h2 className="text-3xl font-bold text-secondary-800 mb-2">Welcome back!</h2>
                        <p className="text-gray-600">Sign in to your account to continue shopping</p>
                    </div>

                {/* Status Message */}
                {status && (
                    <div className="bg-green-50 border border-green-200 rounded-2xl p-4">
                        <div className="text-sm font-medium text-green-800">
                            {status}
                        </div>
                    </div>
                )}

                {/* Login Form */}
                <div className="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
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
                                    placeholder="Enter your email"
                                    autoComplete="username"
                                    required
                                />
                            </div>
                            {errors.email && (
                                <p className="mt-2 text-sm text-red-600">{errors.email}</p>
                            )}
                        </div>

                        {/* Password Field */}
                        <div>
                            <label htmlFor="password" className="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <div className="relative">
                                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <LockClosedIcon className="h-5 w-5 text-gray-400" />
                                </div>
                                <input
                                    id="password"
                                    type={showPassword ? 'text' : 'password'}
                                    name="password"
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    className="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                                    placeholder="Enter your password"
                                    autoComplete="current-password"
                                    required
                                />
                                <button
                                    type="button"
                                    onClick={() => setShowPassword(!showPassword)}
                                    className="absolute inset-y-0 right-0 pr-3 flex items-center"
                                >
                                    {showPassword ? (
                                        <EyeSlashIcon className="h-5 w-5 text-gray-400 hover:text-gray-600" />
                                    ) : (
                                        <EyeIcon className="h-5 w-5 text-gray-400 hover:text-gray-600" />
                                    )}
                                </button>
                            </div>
                            {errors.password && (
                                <p className="mt-2 text-sm text-red-600">{errors.password}</p>
                            )}
                        </div>

                        {/* Remember Me & Forgot Password */}
                        <div className="flex items-center justify-between">
                            <label className="flex items-center">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    checked={data.remember}
                                    onChange={(e) => setData('remember', e.target.checked)}
                                    className="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                />
                                <span className="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>

                            {canResetPassword && (
                                <Link
                                    href={route('password.request')}
                                    className="text-sm text-primary-600 hover:text-primary-700 font-medium"
                                >
                                    Forgot password?
                                </Link>
                            )}
                        </div>

                        {/* Submit Button */}
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-4 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {processing ? 'Signing in...' : 'Sign In'}
                        </button>

                        {/* Divider */}
                        <div className="relative my-6">
                            <div className="absolute inset-0 flex items-center">
                                <div className="w-full border-t border-gray-300"></div>
                            </div>
                            <div className="relative flex justify-center text-sm">
                                <span className="px-2 bg-white text-gray-500">Don't have an account?</span>
                            </div>
                        </div>

                        {/* Register Link */}
                        <Link
                            href={route('register')}
                            className="w-full block text-center bg-gray-100 text-gray-700 py-3 px-4 rounded-2xl font-semibold hover:bg-gray-200 transition-colors"
                        >
                            Create Account
                        </Link>
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
