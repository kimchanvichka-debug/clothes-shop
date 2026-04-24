<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category',
        'image',
        'description',
    ];

    /* Note: We removed 'phone_number' here because products usually 
       don't have phone numbers (orders do!). 
       We also removed the 'array' cast because you are uploading 
       one image at a time.
    */
}