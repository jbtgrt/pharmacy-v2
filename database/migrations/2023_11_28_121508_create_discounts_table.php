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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Example: percentage, fixed, etc.
            $table->decimal('amount', 10, 2); // The discount amount
            $table->date('start_date');
            $table->date('end_date');
            $table->string('customer');
            $table->integer('purchase_quantity');
            $table->decimal('purchase_amount', 10, 2)->default(0);
            $table->timestamp('created_at')->default(now());
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
