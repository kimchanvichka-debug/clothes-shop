<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // Add this line below:
    protected $fillable = [
        'name',
        'price',
        'category',
        'image',
        'description',
        'phone_number', // Add any other columns you have in your table
    ];
    
    // If you're using an array for images, you might also need this:
    protected $casts = [
        'image' => 'array',
    ];
}