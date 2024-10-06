<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    // Define the relationship with the cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Define the relationship with the product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
