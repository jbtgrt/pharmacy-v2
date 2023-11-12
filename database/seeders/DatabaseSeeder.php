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
        $this->call(BrandsTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
    }
}


// php artisan make:controller SupplierProductController --model=SupplierProduct --api --requests
// php artisan make:controller SellerProductController --model=SellerProduct --api --requests
// php artisan make:controller SellerOrderController --model=SellerOrder --api --requests
// php artisan make:controller SupplierStockController --model=SupplierStock --api --requests
// php artisan make:controller SellerStockController --model=SellerStock --api --requests
// php artisan make:controller CategoryController --model=Category --api --requests
// php artisan make:controller ProductController --model=Product --api --requests
// php artisan make:controller BrandController --model=Brand --api --requests
// php artisan make:controller UnitController --model=Unit --api --requests
// php artisan make:controller ProductSupplyController --model=ProductSupply --api --requests
// php artisan make:controller ProductCodeController --model=ProductCode --api --requests

// php artisan make:resource ProductResource