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
        Schema::create('sell_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Product::class, 'product_id');
            $table->foreignIdFor(\App\Models\Category::class, 'category_id');
            $table->foreignIdFor(\App\Models\Brand::class, 'brand_id');
            $table->foreignIdFor(\App\Models\ProductSupply::class, 'supply_id');

            $table->string('unit');
            $table->double('wholesale_price');
            $table->double('retail_price');
            $table->double('discount');
            $table->double('stocks');
            $table->enum('sell_status', ['stock', 'sold', 'expired'])->default('stock');

            $table->timestamp('created_at')->default(now());
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_products');
    }
};
