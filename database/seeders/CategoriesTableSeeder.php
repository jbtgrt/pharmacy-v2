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
            'category_name' => 'Health Care',
            'data'=> '[]',
            'description' => ''
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Digestive Health',
            'data'=> '[]',
            'description' => ''
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Shampoo',
            'data'=> '[]',
            'description' => ''
        ]);
    }
}
