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
        Schema::create('product_supplies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'staff_id');
            $table->foreignIdFor(\App\Models\User::class, 'supplier_id');
            $table->foreignIdFor(\App\Models\Product::class, 'product_id');
            $table->foreignIdFor(\App\Models\Category::class, 'category_id');
            $table->foreignIdFor(\App\Models\Brand::class, 'brand_id');
            $table->foreignIdFor(\App\Models\Unit::class, 'unit_id');

            $table->integer('batch_no');
            $table->date('date_received');
            $table->date('expires_at')->nullable();
            $table->integer('unit_quantity');
            $table->integer('quantity_per_unit')->default(1);
            $table->double('unit_cost');
            $table->double('total_cost');
            $table->integer('batch_stocks');
            $table->string('storage_location')->nullable();
            $table->longText('notes')->nullable();
            $table->enum('product_status', ['stock', 'sold', 'expired'])->default('stock');

            $table->timestamp('created_at')->default(now());
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_supplies');
    }
};
