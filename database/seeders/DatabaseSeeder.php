<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
    }
}


// php artisan make:controller SupplierProductController --model=SupplierProduct --api --requests
// php artisan make:controller SellerProductController --model=SellerProduct --api --requests
// php artisan make:controller SellerOrderController --model=SellerOrder --api --requests
// php artisan make:controller SupplierStockController --model=SupplierStock --api --requests
// php artisan make:controller SellerStockController --model=SellerStock --api --requests
// php artisan make:controller CategoryController --model=Category --api --requests