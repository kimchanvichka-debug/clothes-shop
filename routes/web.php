<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Livewire\Checkout;

// 1. FORCED ADMIN CREATOR
Route::get('/create-admin-xyz', function () {
    try {
        $user = User::where('email', 'admin@example.com')->first();
        
        if (!$user) {
            $user = new User();
            $user->name = 'Admin User';
            $user->email = 'admin@example.com';
        }
        
        $user->password = Hash::make('password123');
        
        // WE ARE FORCING THIS NOW - NO MORE IF CHECK
        $user->phone_number = '099999999'; 
        
        // Manually try to set admin if you know the column is there
        try {
            $user->is_admin = true;
        } catch (\Exception $e) {
            // Ignore if is_admin doesn't exist yet
        }

        $user->save();

        return "<h1>FINAL SUCCESS!</h1> The account is created.<br>Email: <b>admin@example.com</b><br>Password: <b>password123</b>";
    } catch (\Exception $e) {
        return "Critical Error: " . $e->getMessage();
    }
});

// 2. CHECKOUT ROUTE
Route::get('/checkout', Checkout::class)->name('checkout');

// 3. CATEGORY / HOME LOGIC
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