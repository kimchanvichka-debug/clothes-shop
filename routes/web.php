<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Livewire\Checkout;

// 1. THE FINAL ADMIN CREATOR
// Visit: your-url.onrender.com/create-admin-xyz to CREATE the account
Route::get('/create-admin-xyz', function () {
    try {
        // This looks for the admin. If it's not there, it makes one.
        $user = User::where('email', 'admin@example.com')->first();
        
        if (!$user) {
            $user = new User();
            $user->name = 'Admin User';
            $user->email = 'admin@example.com';
        }
        
        // This SETS the password to password123
        $user->password = Hash::make('password123');
        
        // This makes the account an Admin if your database allows it
        if (Schema::hasColumn('users', 'is_admin')) {
            $user->is_admin = true;
        }
        
        $user->save();

        return "<h1>Success!</h1> The admin account has been CREATED.<br>Email: <b>admin@example.com</b><br>Password: <b>password123</b><br><br>You can now use these to log in.";
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