<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('units')->insert([
            'unit_name' => 'Piece (Each)'
        ]);
        DB::table('units')->insert([
            'unit_name' => 'Box'
        ]);
        DB::table('units')->insert([
            'unit_name' => 'Case (or Carton)'
        ]);
        DB::table('units')->insert([
            'unit_name' => 'Pack (pk)'
        ]);

    }
}
