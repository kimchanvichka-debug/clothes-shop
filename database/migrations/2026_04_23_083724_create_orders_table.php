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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('phone_number');
            $table->text('address');
            $table->decimal('total_amount', 10, 2);
            
            // Stores the path to the ABA receipt image
            $table->string('payment_screenshot')->nullable(); 
            
            // Default status for new orders
            $table->string('status')->default('pending'); 

            // Stores the product IDs and quantities as a JSON snapshot
            $table->json('items')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};