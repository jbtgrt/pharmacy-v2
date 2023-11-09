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
            'category_name' => 'Shampoo'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Vitamin'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Drops'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Aerosol'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Cream'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Ointment'
        ]);
    }
}
