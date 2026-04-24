<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * Fields that can be filled via Order::create()
     */
    protected $fillable = [
        'customer_name',
        'phone_number',
        'address',
        'total_amount',
        'payment_screenshot',
        'status',
    ];

    /**
     * Always load orderItems to prevent "N+1" performance issues
     * and ensure they show up in your Admin Panel instantly.
     */
    protected $with = ['orderItems'];

    /**
     * Automatic type conversion
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    /**
     * Set default status automatically if not provided
     */
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->status = $order->status ?? self::STATUS_PENDING;
        });
    }

    /**
     * Relationship: Connects this order to the specific items purchased.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Status Constants
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_CANCELLED = 'cancelled';
}