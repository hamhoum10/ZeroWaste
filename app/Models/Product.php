<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'image_url',
    ];

    // Define the relationship with cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Define the relationship with order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
