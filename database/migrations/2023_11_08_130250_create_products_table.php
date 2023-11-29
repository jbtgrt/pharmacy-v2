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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Category::class, 'category_id');
            $table->foreignIdFor(\App\Models\Brand::class, 'brand_id');
            $table->string('barcode', 50);
            $table->string('product_name', 100);
            $table->string('classification', 50)->nullable();
            $table->string('product_type', 50)->nullable();
            $table->string('formulation', 20)->nullable();
            
            // $table->string('unit', 20)->nullable();
            // $table->double('wholesale_price');
            // $table->double('retail_price');
            // $table->double('discount');
            // $table->double('stocks');
            
            $table->longText('description')->nullable();
            $table->string('image_url', 100)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamp('created_at')->default(now());
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
