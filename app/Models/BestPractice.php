<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestPractice extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'contents',
    'category_id',
    'tags',
    'image',
    'user_id', // Add user_id to fillable array
  ];

  // Define relationships
  public function category() {
    return $this->belongsTo(Category::class);
  }

  public function author() {
    return $this->belongsTo(User::class, 'author_id');
  }

  public function comments()
  {
    return $this->hasMany(Comment::class);
  }

}
