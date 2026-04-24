<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Livewire\Checkout; // <--- Make sure this is here!

// 1. FIXED: Put specific routes FIRST
Route::get('/checkout', Checkout::class)->name('checkout');

// 2. The category/home logic goes SECOND
Route::get('/{category?}', function ($category = null) {
    
    // Clean the category string
    $category = $category ? urldecode($category) : null;

    // Logic: If no category is picked, or the user clicks "All", show everything
    if (!$category || strtolower($category) === 'all') {
        $products = Product::all();
    } else {
        // Only show products where the category matches exactly
        $products = Product::where('category', $category)->get();
    }

    // Send the filtered list to your welcome page
    return view('welcome', [
        'products' => $products,
        'currentCategory' => $category 
    ]);
});