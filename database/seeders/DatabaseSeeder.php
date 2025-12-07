<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cooperative;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@eProShop.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);


        // Create Categories
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'icon' => '📱'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'icon' => '👕'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden', 'icon' => '🏠'],
            ['name' => 'Sports', 'slug' => 'sports', 'icon' => '⚽'],
            ['name' => 'Books', 'slug' => 'books', 'icon' => '📚'],
            ['name' => 'Automotive', 'slug' => 'automotive', 'icon' => '🚗'],
        ];

        foreach ($categories as $index => $categoryData) {
            Category::create([
                ...$categoryData,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }

        // Create Vendor Users and Vendors
        $vendorData = [
            ['name' => 'TechHub Nigeria', 'email' => 'vendor1@eProShop.com', 'business_type' => 'Electronics'],
            ['name' => 'SportZone', 'email' => 'vendor2@eProShop.com', 'business_type' => 'Sports'],
            ['name' => 'Fashion Palace', 'email' => 'vendor3@eProShop.com', 'business_type' => 'Fashion'],
        ];

        foreach ($vendorData as $data) {
            $vendorUser = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password123'),
                'role' => 'vendor',
                'email_verified_at' => now(),
            ]);

            Vendor::create([
                'user_id' => $vendorUser->id,
                'store_name' => $data['name'],
                'slug' => str()->slug($data['name']),
                'description' => 'A trusted vendor specializing in ' . $data['business_type'],
                'business_type' => $data['business_type'],
                'status' => 'approved',
                'is_featured' => true,
            ]);
        }

        // Create Customer Users
        User::create([
            'name' => 'John Doe',
            'email' => 'customer@eProShop.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'cooperative@eProShop.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'cooperative_id' => $cooperative->id,
            'email_verified_at' => now(),
        ]);

        // Create Sample Products
        $electronics = Category::where('slug', 'electronics')->first();
        $fashion = Category::where('slug', 'fashion')->first();
        $sports = Category::where('slug', 'sports')->first();
        
        $techHub = Vendor::where('slug', 'techhub-nigeria')->first();
        $sportZone = Vendor::where('slug', 'sportzone')->first();
        $fashionPalace = Vendor::where('slug', 'fashion-palace')->first();

        if ($electronics && $techHub) {
            Product::create([
                'vendor_id' => $techHub->id,
                'category_id' => $electronics->id,
                'name' => 'Samsung Galaxy S24',
                'slug' => 'samsung-galaxy-s24',
                'description' => 'Latest Samsung flagship smartphone with advanced camera and AI features.',
                'short_description' => 'Premium smartphone with cutting-edge technology.',
                'sku' => 'SGS24-001',
                'price' => 450000,
                'sale_price' => 420000,
                'stock_quantity' => 50,
                'status' => 'published',
                'is_featured' => true,
                'average_rating' => 4.5,
                'review_count' => 128,
            ]);

            Product::create([
                'vendor_id' => $techHub->id,
                'category_id' => $electronics->id,
                'name' => 'MacBook Pro M3',
                'slug' => 'macbook-pro-m3',
                'description' => 'Powerful laptop for professionals with M3 chip and stunning display.',
                'short_description' => 'Professional laptop with M3 chip.',
                'sku' => 'MBP-M3-001',
                'price' => 1200000,
                'sale_price' => 1150000,
                'stock_quantity' => 25,
                'status' => 'published',
                'is_featured' => true,
                'average_rating' => 4.9,
                'review_count' => 245,
            ]);
        }

        if ($sports && $sportZone) {
            Product::create([
                'vendor_id' => $sportZone->id,
                'category_id' => $sports->id,
                'name' => 'Nike Air Max 270',
                'slug' => 'nike-air-max-270',
                'description' => 'Comfortable running shoes with excellent cushioning and style.',
                'short_description' => 'Premium running shoes for athletes.',
                'sku' => 'NAM270-001',
                'price' => 85000,
                'stock_quantity' => 100,
                'status' => 'published',
                'is_featured' => true,
                'average_rating' => 4.8,
                'review_count' => 89,
            ]);
        }

        if ($fashion && $fashionPalace) {
            Product::create([
                'vendor_id' => $fashionPalace->id,
                'category_id' => $fashion->id,
                'name' => 'Designer Ankara Dress',
                'slug' => 'designer-ankara-dress',
                'description' => 'Beautiful handcrafted Ankara dress perfect for special occasions.',
                'short_description' => 'Elegant Ankara dress for women.',
                'sku' => 'DAD-001',
                'price' => 25000,
                'sale_price' => 22000,
                'stock_quantity' => 30,
                'status' => 'published',
                'is_featured' => true,
                'average_rating' => 4.7,
                'review_count' => 56,
            ]);
        }
    }
}
