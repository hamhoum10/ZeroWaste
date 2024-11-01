<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'content']; // Add this line

  public function bestPractice()
  {
    return $this->belongsTo(BestPractice::class);
  }
}
