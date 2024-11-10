<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory;

  protected $fillable = ['name'];

  // Optional relationships
  public function bestPractices() {
    return $this->hasMany(BestPractice::class);
  }
}
