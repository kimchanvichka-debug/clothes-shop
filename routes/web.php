<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Livewire\Checkout;

// 1. ADMIN SETUP (Temporary - Delete after use)
Route::get('/create-admin-xyz', function () {
    $exists = User::where('email', 'admin@example.com')->first();
    if ($exists) return "Admin already exists!";

    User::create([
        'name'     => 'Admin User',
        'email'    => 'admin@example.com', 
        'password' => Hash::make('password123'), 
        'is_admin' => true, 
    ]);

    return "Success! Admin account created. Use admin@example.com and password123 to login.";
});

// 2. CHECKOUT ROUTE
Route::get('/checkout', Checkout::class)->name('checkout');

// 3. CATEGORY / HOME LOGIC (Must be last)
Route::get('/{category?}', function ($category = null) {
    
    $category = $category ? urldecode($category) : null;

    if (!$category || strtolower($category) === 'all') {
        $products = Product::all();
    } else {
        $products = Product::where('category', $category)->get();
    }

    return view('welcome', [
        'products' => $products,
        'currentCategory' => $category 
    ]);
});