import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    ShoppingBagIcon,
    UsersIcon,
    BuildingStorefrontIcon,
    HeartIcon,
    ShieldCheckIcon,
    TruckIcon,
    CreditCardIcon,
    StarIcon
} from '@heroicons/react/24/outline';

export default function About({ stats }) {
    const features = [
        {
            icon: ShoppingBagIcon,
            title: 'Multi-Vendor Marketplace',
            description: 'Shop from hundreds of trusted vendors all in one place'
        },
        {
            icon: CreditCardIcon,
            title: 'Cooperative Integration',
            description: 'Special benefits and sponsored purchases for cooperative members'
        },
        {
            icon: ShieldCheckIcon,
            title: 'Secure Payments',
            description: 'Safe and secure transactions with Paystack integration'
        },
        {
            icon: TruckIcon,
            title: 'Fast Delivery',
            description: 'Quick and reliable delivery across Nigeria'
        }
    ];

    const team = [
        {
            name: 'Adebayo Johnson',
            role: 'CEO & Founder',
            description: 'Passionate about connecting Nigerian businesses with customers'
        },
        {
            name: 'Fatima Abdullahi',
            role: 'CTO',
            description: 'Leading our technology vision and platform development'
        },
        {
            name: 'Chinedu Okafor',
            role: 'Head of Operations',
            description: 'Ensuring smooth operations and vendor relationships'
        }
    ];

    return (
        <AppLayout>
            <Head title="About Us - eProShop" />
            
            <div className="min-h-screen bg-gray-50">
                {/* Hero Section */}
                <div className="bg-gradient-to-br from-primary-500 via-primary-600 to-secondary-800 text-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                        <div className="text-center">
                            <h1 className="text-5xl font-bold mb-6">About eProShop</h1>
                            <p className="text-xl text-gray-200 max-w-3xl mx-auto leading-relaxed">
                                Nigeria's premier multi-vendor cooperative e-commerce platform, 
                                connecting customers with trusted vendors while providing special 
                                benefits for cooperative society members.
                            </p>
                        </div>
                    </div>
                </div>

                {/* Stats Section */}
                <div className="bg-white shadow-lg -mt-12 relative z-10">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
                            <div className="text-center">
                                <div className="text-3xl font-bold text-primary-600 mb-2">
                                    {stats.total_products.toLocaleString()}+
                                </div>
                                <div className="text-gray-600">Products</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-primary-600 mb-2">
                                    {stats.total_vendors.toLocaleString()}+
                                </div>
                                <div className="text-gray-600">Vendors</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-primary-600 mb-2">
                                    {stats.total_customers.toLocaleString()}+
                                </div>
                                <div className="text-gray-600">Customers</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-primary-600 mb-2">25+</div>
                                <div className="text-gray-600">Cooperatives</div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Mission Section */}
                <div className="py-16">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                            <div>
                                <h2 className="text-3xl font-bold text-secondary-800 mb-6">Our Mission</h2>
                                <p className="text-lg text-gray-600 mb-6">
                                    To revolutionize e-commerce in Nigeria by creating a platform that 
                                    empowers local vendors while providing customers with access to 
                                    quality products and services.
                                </p>
                                <p className="text-lg text-gray-600 mb-6">
                                    We believe in the power of cooperative societies and aim to bridge 
                                    the gap between traditional cooperative benefits and modern 
                                    e-commerce convenience.
                                </p>
                                <Link 
                                    href="/vendors/register" 
                                    className="bg-primary-500 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-primary-600 transition-colors inline-block"
                                >
                                    Become a Vendor
                                </Link>
                            </div>
                            <div className="bg-gradient-to-br from-primary-100 to-accent-100 rounded-2xl p-8">
                                <div className="grid grid-cols-2 gap-6">
                                    <div className="text-center">
                                        <HeartIcon className="h-12 w-12 text-primary-600 mx-auto mb-3" />
                                        <h3 className="font-semibold text-secondary-800">Customer First</h3>
                                    </div>
                                    <div className="text-center">
                                        <UsersIcon className="h-12 w-12 text-primary-600 mx-auto mb-3" />
                                        <h3 className="font-semibold text-secondary-800">Community</h3>
                                    </div>
                                    <div className="text-center">
                                        <ShieldCheckIcon className="h-12 w-12 text-primary-600 mx-auto mb-3" />
                                        <h3 className="font-semibold text-secondary-800">Trust</h3>
                                    </div>
                                    <div className="text-center">
                                        <StarIcon className="h-12 w-12 text-primary-600 mx-auto mb-3" />
                                        <h3 className="font-semibold text-secondary-800">Excellence</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Features Section */}
                <div className="bg-white py-16">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center mb-12">
                            <h2 className="text-3xl font-bold text-secondary-800 mb-4">Why Choose eProShop?</h2>
                            <p className="text-gray-600 max-w-2xl mx-auto">
                                We're more than just an e-commerce platform. We're a community 
                                that supports local businesses and cooperative societies.
                            </p>
                        </div>
                        
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            {features.map((feature, index) => (
                                <div key={index} className="text-center">
                                    <div className="bg-primary-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <feature.icon className="h-8 w-8 text-primary-600" />
                                    </div>
                                    <h3 className="text-xl font-semibold text-secondary-800 mb-2">
                                        {feature.title}
                                    </h3>
                                    <p className="text-gray-600">{feature.description}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>

                {/* Team Section */}
                <div className="py-16">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center mb-12">
                            <h2 className="text-3xl font-bold text-secondary-800 mb-4">Meet Our Team</h2>
                            <p className="text-gray-600 max-w-2xl mx-auto">
                                Passionate professionals dedicated to transforming e-commerce in Nigeria
                            </p>
                        </div>
                        
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                            {team.map((member, index) => (
                                <div key={index} className="bg-white rounded-2xl shadow-lg p-6 text-center">
                                    <div className="w-24 h-24 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                                        <UsersIcon className="h-12 w-12 text-white" />
                                    </div>
                                    <h3 className="text-xl font-semibold text-secondary-800 mb-1">
                                        {member.name}
                                    </h3>
                                    <p className="text-primary-600 font-medium mb-3">{member.role}</p>
                                    <p className="text-gray-600">{member.description}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>

                {/* CTA Section */}
                <div className="bg-secondary-800 text-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
                        <h2 className="text-3xl font-bold mb-4">Ready to Join the eProShop Community?</h2>
                        <p className="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                            Whether you're a customer looking for great products or a vendor 
                            wanting to grow your business, we're here for you.
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link 
                                href="/shop" 
                                className="bg-primary-500 text-white px-8 py-4 rounded-2xl font-semibold hover:bg-primary-600 transition-colors"
                            >
                                Start Shopping
                            </Link>
                            <Link 
                                href="/vendors/register" 
                                className="border-2 border-accent-500 text-accent-500 px-8 py-4 rounded-2xl font-semibold hover:bg-accent-500 hover:text-secondary-800 transition-colors"
                            >
                                Become a Vendor
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
