import { Head, Link, useForm } from '@inertiajs/react';
import { 
    ShoppingBagIcon, 
    EyeIcon, 
    EyeSlashIcon,
    LockClosedIcon,
    ShieldCheckIcon
} from '@heroicons/react/24/outline';
import { useState } from 'react';

export default function ConfirmPassword() {
    const { data, setData, post, processing, errors, reset } = useForm({
        password: '',
    });

    const [showPassword, setShowPassword] = useState(false);

    const submit = (e) => {
        e.preventDefault();

        post(route('password.confirm'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <div className="min-h-screen bg-gradient-to-br from-primary-50 via-white to-accent-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <Head title="Confirm Password - eProShop" />
            
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
                    <h2 className="text-2xl font-bold text-secondary-800 mb-2">Confirm Password</h2>
                    <p className="text-gray-600">Please confirm your password to continue</p>
                </div>

                {/* Confirm Form */}
                <div className="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div className="text-center mb-6">
                        <div className="bg-amber-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                            <ShieldCheckIcon className="h-8 w-8 text-amber-600" />
                        </div>
                        <h3 className="text-lg font-semibold text-secondary-800 mb-2">Security Check</h3>
                        <p className="text-gray-600 text-sm">
                            This is a secure area of the application. Please confirm your password before continuing.
                        </p>
                    </div>

                    <form onSubmit={submit} className="space-y-6">
                        {/* Password Field */}
                        <div>
                            <label htmlFor="password" className="block text-sm font-medium text-gray-700 mb-2">
                                Current Password
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
                                    placeholder="Enter your current password"
                                    autoComplete="current-password"
                                    required
                                    autoFocus
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

                        {/* Security Notice */}
                        <div className="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                            <div className="flex items-start">
                                <ShieldCheckIcon className="h-5 w-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" />
                                <div className="text-sm text-blue-800">
                                    <p className="font-medium mb-1">Why do we need this?</p>
                                    <p>For your security, we require password confirmation before accessing sensitive areas of your account.</p>
                                </div>
                            </div>
                        </div>

                        {/* Submit Button */}
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-4 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                        >
                            <ShieldCheckIcon className="h-5 w-5" />
                            <span>{processing ? 'Confirming...' : 'Confirm Password'}</span>
                        </button>

                        {/* Cancel Link */}
                        <div className="text-center">
                            <Link
                                href={route('dashboard')}
                                className="text-sm text-gray-600 hover:text-primary-600 transition-colors"
                            >
                                Cancel and go back
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
    );
}
