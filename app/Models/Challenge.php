<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
  use HasFactory;

// Specify the fillable attributes
  protected $fillable = [
    'title',
    'description',
    'category',
    'start_date',
    'end_date',
    'created_by',
    'participants_count',
    'status',
    'created_at',
    'updated_at',
  ];

  public function users()
  {
    return $this->belongsToMany(User::class);
  }
  public function getStatusAttribute(): string
  {
    $now = now();
    if ($this->end_date < $now) {
      return 'Ended';
    } elseif ($this->start_date <= $now && $this->end_date >= $now) {
      return 'Ongoing';
    } else {
      return 'Upcoming';
    }
  }
}
