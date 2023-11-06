<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SupplierProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('supplier_products')->insert([
            'user_id' => '3',
            'category_id' => '1',
            'product_name' => 'Nutrilin Drops 30ml',
            'price' => '124.50',
            'description' => 'This is description',
            'expires_at' => '2024-01-22'
        ]);
        DB::table('supplier_products')->insert([
            'user_id' => '3',
            'category_id' => '1',
            'product_name' => 'Nutroplex W/ Lysine Syrup 120ml',
            'price' => '157.50',
            'description' => 'This is description',
            'expires_at' => '2024-02-16'
        ]);
        DB::table('supplier_products')->insert([
            'user_id' => '3',
            'category_id' => '2',
            'product_name' => 'Flotera Probiotic Chewable Tablet',
            'price' => '39.50',
            'description' => 'This is description',
            'expires_at' => '2025-02-16'
        ]);
        DB::table('supplier_products')->insert([
            'user_id' => '3',
            'category_id' => '3',
            'product_name' => 'PALMOLIVE NATURALS INTENSIVE MOISTURE 180ML',
            'price' => '137.75',
            'description' => 'This is description',
            'expires_at' => '2025-08-13'
        ]);
    }
}
