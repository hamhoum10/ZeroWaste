<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
    ];

    // Define the relationship with the user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
