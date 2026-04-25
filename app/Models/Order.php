<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone_number',
        'address',
        'total_amount',
        'payment_screenshot',
        'status',
    ];

    // Ensure we load the items automatically
    protected $with = ['orderItems'];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Status Constants
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_CANCELLED = 'cancelled';

    protected static function booted()
    {
        static::creating(function ($order) {
            // Safety check: force pending status if it's empty
            if (empty($order->status)) {
                $order->status = self::STATUS_PENDING;
            }
        });
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}