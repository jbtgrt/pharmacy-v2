<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;


class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            'brand_name' => 'No Brand'
        ]);
        DB::table('brands')->insert([
            'brand_name' => 'Unilab'
        ]);
        DB::table('brands')->insert([
            'brand_name' => 'Daflon'
        ]);
        DB::table('brands')->insert([
            'brand_name' => 'Biogesic'
        ]);
        DB::table('brands')->insert([
            'brand_name' => 'Advil'
        ]);
        DB::table('brands')->insert([
            'brand_name' => 'Campol'
        ]);
    }
}
