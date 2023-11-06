<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SupplierStocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('supplier_stocks')->insert([
            'user_id' => '3',
            'product_id' => '1',
            'quantity' => '50'
        ]);
        DB::table('supplier_stocks')->insert([
            'user_id' => '3',
            'product_id' => '2',
            'quantity' => '30'
        ]);
        DB::table('supplier_stocks')->insert([
            'user_id' => '3',
            'product_id' => '3',
            'quantity' => '20'
        ]);
        DB::table('supplier_stocks')->insert([
            'user_id' => '3',
            'product_id' => '4',
            'quantity' => '25'
        ]);
    }
}
