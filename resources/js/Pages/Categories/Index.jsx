import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    ShoppingBagIcon,
    ArrowRightIcon
} from '@heroicons/react/24/outline';

export default function CategoriesIndex({ categories }) {
    return (
        <AppLayout>
            <Head title="Categories - eProShop" />
            
            <div className="min-h-screen bg-gray-50">
                {/* Header */}
                <div className="bg-white shadow-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                        <div className="text-center">
                            <h1 className="text-4xl font-bold text-secondary-800 mb-4">Shop by Category</h1>
                            <p className="text-xl text-gray-600 max-w-2xl mx-auto">
                                Discover thousands of products across all categories from trusted vendors
                            </p>
                        </div>
                    </div>
                </div>

                {/* Categories Grid */}
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {categories.map((category) => (
                            <Link
                                key={category.id}
                                href={`/categories/${category.slug}`}
                                className="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                            >
                                <div className="relative">
                                    <div className="aspect-video bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                        <div className="text-6xl">{category.icon || '📦'}</div>
                                    </div>
                                    <div className="absolute top-4 right-4 bg-white rounded-full px-3 py-1 text-sm font-semibold text-primary-600">
                                        {category.products_count} products
                                    </div>
                                </div>
                                
                                <div className="p-6">
                                    <h3 className="text-xl font-bold text-secondary-800 mb-2 group-hover:text-primary-600 transition-colors">
                                        {category.name}
                                    </h3>
                                    {category.description && (
                                        <p className="text-gray-600 mb-4 line-clamp-2">
                                            {category.description}
                                        </p>
                                    )}
                                    
                                    {/* Subcategories */}
                                    {category.children && category.children.length > 0 && (
                                        <div className="mb-4">
                                            <div className="flex flex-wrap gap-2">
                                                {category.children.slice(0, 3).map((child) => (
                                                    <span
                                                        key={child.id}
                                                        className="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full"
                                                    >
                                                        {child.name}
                                                    </span>
                                                ))}
                                                {category.children.length > 3 && (
                                                    <span className="text-xs text-gray-500">
                                                        +{category.children.length - 3} more
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                    )}
                                    
                                    <div className="flex items-center justify-between">
                                        <span className="text-primary-600 font-semibold">
                                            Explore Category
                                        </span>
                                        <ArrowRightIcon className="h-5 w-5 text-primary-600 group-hover:translate-x-1 transition-transform" />
                                    </div>
                                </div>
                            </Link>
                        ))}
                    </div>

                    {categories.length === 0 && (
                        <div className="text-center py-12">
                            <ShoppingBagIcon className="h-16 w-16 text-gray-400 mx-auto mb-4" />
                            <h3 className="text-lg font-semibold text-gray-600 mb-2">No categories found</h3>
                            <p className="text-gray-500">Categories will appear here once they are added</p>
                        </div>
                    )}
                </div>

                {/* CTA Section */}
                <div className="bg-secondary-800 text-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
                        <h2 className="text-3xl font-bold mb-4">Can't find what you're looking for?</h2>
                        <p className="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                            Browse all products or use our search to find exactly what you need
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link 
                                href="/shop" 
                                className="bg-primary-500 text-white px-8 py-4 rounded-2xl font-semibold hover:bg-primary-600 transition-colors"
                            >
                                Browse All Products
                            </Link>
                            <Link 
                                href="/vendors" 
                                className="border-2 border-accent-500 text-accent-500 px-8 py-4 rounded-2xl font-semibold hover:bg-accent-500 hover:text-secondary-800 transition-colors"
                            >
                                View All Vendors
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
