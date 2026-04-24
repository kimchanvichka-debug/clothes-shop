<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Livewire\Checkout;

// 1. THE FINAL ADMIN CREATOR (Fixed for phone_number error)
Route::get('/create-admin-xyz', function () {
    try {
        $user = User::where('email', 'admin@example.com')->first();
        
        if (!$user) {
            $user = new User();
            $user->name = 'Admin User';
            $user->email = 'admin@example.com';
        }
        
        $user->password = Hash::make('password123');
        
        // FIX: Satisfy the NOT NULL constraint for phone_number
        if (Schema::hasColumn('users', 'phone_number')) {
            $user->phone_number = '0000000000'; 
        }

        // Only set is_admin if the column exists
        if (Schema::hasColumn('users', 'is_admin')) {
            $user->is_admin = true;
        }
        
        $user->save();

        return "<h1>Success!</h1> The admin account has been CREATED.<br>Email: <b>admin@example.com</b><br>Password: <b>password123</b><br><br>Go to your login page now!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
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