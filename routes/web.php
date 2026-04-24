<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Livewire\Checkout;

// THE ADMIN CREATOR (UPDATED TO FIX 403)
Route::get('/create-admin-xyz', function () {
    try {
        $user = User::where('email', 'admin@example.com')->first();
        
        if (!$user) {
            $user = new User();
            $user->name = 'Admin User';
            $user->email = 'admin@example.com';
        }
        
        $user->password = Hash::make('password123');
        $user->phone_number = '099999999'; 

        // Try to set admin status only if the column exists to prevent crashes
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'is_admin')) {
            $user->is_admin = true;
        }

        $user->save();

        return "<h1>ULTIMATE SUCCESS!</h1> Account created.<br>Email: <b>admin@example.com</b><br>Password: <b>password123</b><br><br><b>Step 2:</b> Go to your Login page and try again!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
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