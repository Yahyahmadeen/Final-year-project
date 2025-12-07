import { Head, Link, useForm } from '@inertiajs/react';
import { 
    ShoppingBagIcon, 
    EyeIcon, 
    EyeSlashIcon,
    EnvelopeIcon,
    LockClosedIcon,
    UserIcon
} from '@heroicons/react/24/outline';
import { useState } from 'react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const [showPassword, setShowPassword] = useState(false);
    const [showConfirmPassword, setShowConfirmPassword] = useState(false);

    const submit = (e) => {
        e.preventDefault();

        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <div className="min-h-screen flex">
            <Head title="Register - eProShop" />
            
            {/* Left Side - Background Image */}
            <div className="hidden lg:flex lg:w-1/2 relative">
                <div 
                    className="absolute inset-0 bg-cover bg-center bg-no-repeat"
                    style={{
                        backgroundImage: `url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80')`
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
                            Join our growing community
                        </h2>
                        <p className="text-xl text-white/90 leading-relaxed">
                            Create your account today and get access to exclusive deals, trusted vendors, and a seamless shopping experience.
                        </p>
                        <div className="space-y-4 pt-4">
                            <div className="flex items-center space-x-3">
                                <div className="w-2 h-2 bg-accent-400 rounded-full"></div>
                                <span className="text-white/90">Access to 1000+ verified vendors</span>
                            </div>
                            <div className="flex items-center space-x-3">
                                <div className="w-2 h-2 bg-accent-400 rounded-full"></div>
                                <span className="text-white/90">Secure payment processing</span>
                            </div>
                            <div className="flex items-center space-x-3">
                                <div className="w-2 h-2 bg-accent-400 rounded-full"></div>
                                <span className="text-white/90">24/7 customer support</span>
                            </div>
                            <div className="flex items-center space-x-3">
                                <div className="w-2 h-2 bg-accent-400 rounded-full"></div>
                                <span className="text-white/90">Fast and reliable delivery</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* Right Side - Register Form */}
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
                        <h2 className="text-3xl font-bold text-secondary-800 mb-2">Create Account</h2>
                        <p className="text-gray-600">Join eProShop and start shopping from trusted vendors</p>
                    </div>

                {/* Register Form */}
                <div className="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <form onSubmit={submit} className="space-y-6">
                        {/* Name Field */}
                        <div>
                            <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">
                                Full Name
                            </label>
                            <div className="relative">
                                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <UserIcon className="h-5 w-5 text-gray-400" />
                                </div>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                                    placeholder="Enter your full name"
                                    autoComplete="name"
                                    required
                                />
                            </div>
                            {errors.name && (
                                <p className="mt-2 text-sm text-red-600">{errors.name}</p>
                            )}
                        </div>

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
                                    placeholder="Create a password"
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
                                Confirm Password
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
                                    placeholder="Confirm your password"
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

                        {/* Terms and Conditions */}
                        <div className="flex items-start">
                            <input
                                type="checkbox"
                                id="terms"
                                className="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded mt-1"
                                required
                            />
                            <label htmlFor="terms" className="ml-2 text-sm text-gray-600">
                                I agree to the{' '}
                                <Link href="/terms" className="text-primary-600 hover:text-primary-700 font-medium">
                                    Terms of Service
                                </Link>{' '}
                                and{' '}
                                <Link href="/privacy" className="text-primary-600 hover:text-primary-700 font-medium">
                                    Privacy Policy
                                </Link>
                            </label>
                        </div>

                        {/* Submit Button */}
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-white py-3 px-4 rounded-2xl font-semibold hover:from-primary-600 hover:to-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {processing ? 'Creating Account...' : 'Create Account'}
                        </button>

                        {/* Divider */}
                        <div className="relative my-6">
                            <div className="absolute inset-0 flex items-center">
                                <div className="w-full border-t border-gray-300"></div>
                            </div>
                            <div className="relative flex justify-center text-sm">
                                <span className="px-2 bg-white text-gray-500">Already have an account?</span>
                            </div>
                        </div>

                        {/* Login Link */}
                        <Link
                            href={route('login')}
                            className="w-full block text-center bg-gray-100 text-gray-700 py-3 px-4 rounded-2xl font-semibold hover:bg-gray-200 transition-colors"
                        >
                            Sign In
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
