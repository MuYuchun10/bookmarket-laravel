<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'status', 'customer_name',
        'customer_email', 'phone', 'city', 'street', 'house',
        'flat', 'comment', 'subtotal', 'discount', 'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'order_items'
        )->withPivot('quantity', 'price')
        ->withTimestamps();
    }
}