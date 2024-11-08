<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  use HasFactory;

  protected $fillable = ['user_id', 'content', 'best_practice_id'];

  public function bestPractice()
  {
    return $this->belongsTo(BestPractice::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
