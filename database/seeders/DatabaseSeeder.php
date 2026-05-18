<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\StockMovement;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('categories')->truncate();
        DB::table('products')->truncate();
        DB::table('suppliers')->truncate();
        DB::table('purchase_orders')->truncate();
        DB::table('purchase_order_items')->truncate();
        DB::table('sales_orders')->truncate();
        DB::table('sales_order_items')->truncate();
        DB::table('stock_movements')->truncate();
        DB::table('transactions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Users
        $admin = User::create([
            'name' => 'Administrator Mesama',
            'email' => 'admin@mesama.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $finance = User::create([
            'name' => 'Finance Executive',
            'email' => 'finance@mesama.com',
            'password' => Hash::make('password'),
            'role' => 'finance',
        ]);

        $warehouse = User::create([
            'name' => 'Warehouse Ops',
            'email' => 'warehouse@mesama.com',
            'password' => Hash::make('password'),
            'role' => 'warehouse',
        ]);

        $purchasing = User::create([
            'name' => 'Procurement Lead',
            'email' => 'purchasing@mesama.com',
            'password' => Hash::make('password'),
            'role' => 'purchasing',
        ]);

        // 2. Categories
        $categoriesData = [
            ['name' => 'Facial Serum', 'slug' => 'facial-serum'],
            ['name' => 'Moisturizer', 'slug' => 'moisturizer'],
            ['name' => 'Cleanser', 'slug' => 'cleanser'],
            ['name' => 'Sun Protection', 'slug' => 'sun-protection'],
            ['name' => 'Treatment Mask', 'slug' => 'mask'],
        ];

        foreach ($categoriesData as $cat) {
            Category::create($cat);
        }

        // 3. Suppliers
        $suppliersData = [
            ['code' => 'SUP-001', 'name' => 'Global Skincare Solutions', 'contact_person' => 'Sarah Johnson', 'email' => 'orders@globalskincare.com'],
            ['code' => 'SUP-002', 'name' => 'Dermatech Labs', 'contact_person' => 'Dr. Michael Chen', 'email' => 'michael@dermatech.com'],
            ['code' => 'SUP-003', 'name' => 'Nature Care Corp', 'contact_person' => 'Elena Rodriguez', 'email' => 'elena@naturecare.org'],
            ['code' => 'SUP-004', 'name' => 'Premium Beauty Dist', 'contact_person' => 'James Wilson', 'email' => 'james@premiumbeauty.id'],
            ['code' => 'SUP-005', 'name' => 'Innovate Cosmeceuticals', 'contact_person' => 'Yuki Tanaka', 'email' => 'yuki@innovatecosme.jp'],
        ];

        foreach ($suppliersData as $sup) {
            Supplier::create($sup + [
                'phone' => '0812' . rand(10000000, 99999999),
                'address' => 'Central Logistics District No. ' . rand(1, 100),
                'status' => 'active'
            ]);
        }

        // 4. Products (50 Products)
        $productTemplates = [
            'facial-serum' => ['Advanced Retinol Night Serum', 'Vitamin C Brightening Concentrate', 'Hyaluronic Acid 2% + B5', 'Niacinamide 10% Zinc 1%', 'Peptide Complex Serum', 'AHA 30% + BHA 2% Peeling Solution', 'Salicylic Acid 2% Masque', 'Caffeine Solution 5% + EGCG', 'Matrixyl 10% + HA', 'Alpha Arbutin 2% + HA'],
            'moisturizer' => ['Natural Moisturizing Factors + HA', 'Ceramide Barrier Cream', 'Lightweight Soothing Gel', 'Daily Defense Lotion SPF 30', 'Intensive Night Repair Balm', 'Oil-Free Mattifying Moisturizer', 'Hydrating Rich Cream', 'Probiotic Skin Balancer', 'Watermelon Glow Pink Juice', 'Rosehip Seed Oil Moisturizer'],
            'cleanser' => ['Squalane Cleanser', 'Gentle Foaming Wash', 'Salicylic Acid Daily Cleanser', 'Micellar Water Ultra', 'Oil Control Cleansing Balm', 'Hydrating Facial Cleanser', 'Exfoliating Jelly Cleanser', 'Amino Acid Gentle Wash', 'Centella Soothing Foam', 'Deep Pore Cleansing Clay'],
            'sun-protection' => ['Mineral UV Filters SPF 30', 'Invisible Shield SPF 50', 'Daily UV Defense Sunscreen', 'Matte Finish Sunscreen Stick', 'Tinted Moisturizer with SPF', 'Broad Spectrum Aqua Gel', 'Sheer Physical Protector', 'Urban Environment Protection', 'Sport Defense Sun Block', 'Sensitive Skin Sunscreen'],
            'mask' => ['Volcanic Ash Pore Mask', 'Sheet Mask Brightening Pack', 'Sleep Repair Over-night Mask', 'Hydrating Rose Petal Mask', 'Detoxifying Charcoal Peel', 'Revitalizing Gold Collagen', 'Soothing Aloe Vera Gel Mask', 'Vitamin E Energizing Mask', 'Tea Tree Oil Sheet Mask', 'Pink Clay Exfoliating Mask']
        ];

        $productImages = [
            'facial-serum' => 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=500&q=80',
            'moisturizer' => 'https://images.unsplash.com/photo-1556229167-731383569762?w=500&q=80',
            'cleanser' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=500&q=80',
            'sun-protection' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500&q=80',
            'mask' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=500&q=80',
        ];

        $skuPrefix = 'MSM-';
        $pCount = 1;
        foreach ($productTemplates as $slug => $names) {
            $cat = Category::where('slug', $slug)->first();
            foreach ($names as $name) {
                Product::create([
                    'category_id' => $cat->id,
                    'sku' => $skuPrefix . strtoupper(substr($slug, 0, 3)) . '-' . str_pad($pCount++, 3, '0', STR_PAD_LEFT),
                    'name' => $name,
                    'description' => 'Premium ' . $name . ' formulated for professional results.',
                    'unit' => 'Pcs',
                    'purchase_price' => rand(50000, 150000),
                    'selling_price' => rand(200000, 450000),
                    'stock' => rand(20, 150),
                    'min_stock' => rand(10, 20),
                    'image' => $productImages[$slug] ?? null,
                ]);
            }
        }
    }
}
