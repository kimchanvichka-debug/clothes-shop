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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            
            // Link to the main order (if order is deleted, items are deleted)
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            
            // Link to the product
            $table->foreignId('product_id')->constrained();
            
            // Specific order details
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // To keep a record of the price at time of sale
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};