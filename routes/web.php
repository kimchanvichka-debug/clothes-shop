<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Livewire\Checkout;

// 1. THE ADMIN, VISUALS, AND IMAGE UPLOAD FIX
Route::get('/create-admin-xyz', function () {
    try {
        // Create or Update the Admin Account
        $user = User::where('email', 'admin@example.com')->first();
        if (!$user) {
            $user = new User();
            $user->name = 'Admin User';
            $user->email = 'admin@example.com';
        }
        $user->password = Hash::make('password123');
        $user->phone_number = '099999999'; 

        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'is_admin')) {
            $user->is_admin = true;
        }
        $user->save();

        // FIX VISUALS & ICONS
        \Illuminate\Support\Facades\Artisan::call('filament:assets');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        
        // FIX IMAGE UPLOADS (Connects the storage folder)
        \Illuminate\Support\Facades\Artisan::call('storage:link');

        return "<h1>SUCCESS!</h1> 
                <p>1. Account created: <b>admin@example.com</b> / <b>password123</b></p>
                <p>2. Design Styles & Icons fixed.</p>
                <p>3. Image Uploads enabled.</p>
                <a href='/leeminka/login' style='padding:10px; background:purple; color:white; text-decoration:none; border-radius:5px;'>GO TO LOGIN</a>";
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