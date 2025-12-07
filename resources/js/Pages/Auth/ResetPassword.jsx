import { Head, Link, useForm } from '@inertiajs/react';
import { 
    ShoppingBagIcon, 
    EyeIcon, 
    EyeSlashIcon,
    EnvelopeIcon,
    LockClosedIcon,
    KeyIcon
} from '@heroicons/react/24/outline';
import { useState } from 'react';

export default function ResetPassword({ token, email }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        token: token,
        email: email,
        password: '',
        password_confirmation: '',
    });

    const [showPassword, setShowPassword] = useState(false);
    const [showConfirmPassword, setShowConfirmPassword] = useState(false);

    const submit = (e) => {
        e.preventDefault();

        post(route('password.store'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <div className="min-h-screen flex">
            <Head title="Reset Password - eProShop" />
            
            {/* Left Side - Background Image */}
            <div className="hidden lg:flex lg:w-1/2 relative">
                <div 
                    className="absolute inset-0 bg-cover bg-center bg-no-repeat"
                    style={{
                        backgroundImage: `url('https://images.unsplash.com/photo-1555421689-491a97ff2040?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80')`
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
                            Create a strong password
                        </h2>
                        <p className="text-xl text-white/90 leading-relaxed">
                            Your security is our priority. Create a strong, unique password to protect your eProShop account.
                        </p>
                        <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-6 space-y-3">
                            <h3 className="text-lg font-semibold">Password Security Tips</h3>
                            <div className="space-y-2 text-white/90 text-sm">
                                <p>• Use at least 8 characters</p>
                                <p>• Mix uppercase and lowercase letters</p>
                                <p>• Include numbers and special characters</p>
                                <p>• Avoid common words or personal info</p>
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
                        <h2 className="text-3xl font-bold text-secondary-800 mb-2">Reset Password</h2>
                        <p className="text-gray-600">Create a new secure password for your account</p>
                    </div>

                {/* Reset Form */}
                <div className="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div className="text-center mb-6">
                        <div className="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                            <KeyIcon className="h-8 w-8 text-primary-600" />
                        </div>
                        <p className="text-gray-600 text-sm">
                            Enter your new password below
                        </p>
                    </div>

                    <form onSubmit={submit} className="space-y-6">
                        {/* Email Field (Read-only) */}
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
                                    className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-2xl bg-gray-50 text-gray-600 cursor-not-allowed"
                                    readOnly
                                />
                            </div>
                            {errors.email && (
                                <p className="mt-2 text-sm text-red-600">{errors.email}</p>
                            )}
                        </div>

                        {/* Password Field */}
                        <div>
                            <label htmlFor="password" className="block text-sm font-medium text-gray-700 mb-2">
                                New Password
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
                                    placeholder="Enter your new password"
                                    autoComplete="new-password"
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

                        {/* Confirm Password Field */}
                        <div>
                            <label htmlFor="password_confirmation" className="block text-sm font-medium text-gray-700 mb-2">
                                Confirm New Password
                            </label>
                            <div className="relative">
                                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <LockClosedIcon className="h-5 w-5 text-gray-400" />
                                </div>
                                <input
                                    id="password_confirmation"
                                    type={showConfirmPassword ? 'text' : 'password'}
                                    name="password_confirmation"
                                    value={data.password_confirmation}
                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                    className="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                                    placeholder="Confirm your new password"
                                    autoComplete="new-password"
                                    required
                                />
                                <button
                                    type="button"
                                    onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                                    className="absolute inset-y-0 right-0 pr-3 flex items-center"
                                >
                                    {showConfirmPassword ? (
                                        <EyeSlashIcon className="h-5 w-5 text-gray-400 hover:text-gray-600" />
                                    ) : (
                                        <EyeIcon className="h-5 w-5 text-gray-400 hover:text-gray-600" />
                                    )}
                                </button>
                            </div>
                            {errors.password_confirmation && (
                                <p className="mt-2 text-sm text-red-600">{errors.password_confirmation}</p>
                            )}
                        </div>

                        {/* Password Requirements */}
                        <div className="bg-gray-50 rounded-2xl p-4">
                            <h4 className="text-sm font-medium text-gray-700 mb-2">Password Requirements:</h4>
                            <ul className="text-xs text-gray-600 space-y-1">
                                <li>• At least 8 characters long</li>
                                <li>• Contains uppercase and lowercase letters</li>
                                <li>• Contains at least one number</li>
                                <li>• Contains at least one special character</li>
                            </ul>
                        </div>

                        {/* Submit Button */}
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-4 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                        >
                            <KeyIcon className="h-5 w-5" />
                            <span>{processing ? 'Resetting Password...' : 'Reset Password'}</span>
                        </button>
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
