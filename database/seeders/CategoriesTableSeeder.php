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
            'user_id' => '3',
            'category_name' => 'Health Care, Vitamin, Vitamin A',
            // 'data'=> '[{"uuid":'',"Health Care": [{}],{"Personal Care": {}},]',
            'data'=> '[]',
            'description' => ''
        ]);
        DB::table('categories')->insert([
            'user_id' => '3',
            'category_name' => 'Health Care, Digestive Health, Probiotics',
            'data'=> '[]',
            'description' => ''
        ]);
        DB::table('categories')->insert([
            'user_id' => '3',
            'category_name' => 'Personal Care, Hair Care, Shampoo',
            'data'=> '[]',
            'description' => ''
        ]);
    }
}
