<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'role', // Add the 'role' field here
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  /**
   * Relationship with orders.
   * A user can have many orders.
   */
  public function orders()
  {
    return $this->hasMany(Order::class);
  }

  /**
   * Relationship with cart.
   * A user can have only one cart.
   */
  public function cart()
  {
    return $this->hasOne(Cart::class);
  }


  public function likedTips()
  {
    return $this->belongsToMany(RecyclingTip::class, 'tip_likes');
  }

  public function challenges()
  {
    return $this->belongsToMany(Challenge::class);
  }
}
