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
            $table->string('name'); 
            $table->text('description')->nullable(); 
            $table->decimal('price', 10, 2); 
            $table->string('image')->nullable(); // Stores the file path for the product photo
            $table->string('category')->nullable(); // Stores 'Dress', 'Bikini', etc.
            $table->integer('stock')->default(1); // Default to 1 so items show as available
            $table->boolean('is_visible')->default(true); // Toggle to hide/show products
            $table->timestamps();
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