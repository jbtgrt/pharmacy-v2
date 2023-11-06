<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('supplier_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('product_name');
            $table->double('price');
            $table->longText('description');
            $table->longText('information');
            $table->longText('notice');
            $table->longText('tag');
            $table->string('image_url', 255)->nullable();
            $table->date('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_products');
    }
};


//php artisan make:migration create_supplier_categories_table
//php artisan make:migration create_supplier_stocks_table
//php artisan make:migration create_supplier_products_table
//php artisan make:migration create_seller_products_table
//php artisan make:migration create_seller_stocks_table

//php artisan make:migration create_seller_categories_table
//php artisan make:migration create_seller_stocks_table
