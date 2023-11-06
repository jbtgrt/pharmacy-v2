<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'address' => 'Sta. Maria, Gloria, Oriental Mindoro',
            'phone_number' => '09383994498',
            'password' => bcrypt('User123#'),
            'image_url' => 'images/avatars/user-image.jpg'
        ]);
        
        DB::table('users')->insert([
            'role_id' => '2',
            'first_name' => 'Staff',
            'last_name' => 'Staff',
            'email' => 'staff@gmail.com',
            'address' => 'Sta. Maria, Gloria, Oriental Mindoro',
            'phone_number' => '09381800984',
            'password' => bcrypt('User123#'),
            'image_url' => 'images/avatars/user-image.jpg'
        ]);
        
        DB::table('users')->insert([
            'role_id' => '3',
            'first_name' => 'Supplier',
            'last_name' => 'Supplier',
            'email' => 'supplier@gmail.com',
            'address' => 'Sta. Maria, Gloria, Oriental Mindoro',
            'phone_number' => '09381989434',
            'password' => bcrypt('User123#'),
            'image_url' => 'images/avatars/user-image.jpg'
        ]);
    }
}


// php artisan make:seeder UsersTableSeeder
// php artisan migrate
// php artisan db:seed --class=DatabaseSeeder
// php artisan make:seeder CategoriesTableSeeder