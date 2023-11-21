<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('categories')->insert([
            'category_name' => 'Medicine'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Medical Supplies'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Personal Care'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Protection & Hygiene'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Beauty Supplements'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Mom & Baby'
        ]);
    }
}
