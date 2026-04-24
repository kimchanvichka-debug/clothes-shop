<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Livewire\Checkout;

// THE "NO-FAIL" ADMIN CREATOR
Route::get('/create-admin-xyz', function () {
    try {
        // Look for the user or create a new one
        $user = User::where('email', 'admin@example.com')->first();
        
        if (!$user) {
            $user = new User();
            $user->name = 'Admin User';
            $user->email = 'admin@example.com';
        }
        
        $user->password = Hash::make('password123');
        
        // This satisfies the database phone number requirement
        $user->phone_number = '099999999'; 

        // We removed the is_admin part because the column doesn't exist yet
        $user->save();

        return "<h1>ULTIMATE SUCCESS!</h1> The account is created.<br>Email: <b>admin@example.com</b><br>Password: <b>password123</b><br><br>You can now go to the login page!";
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