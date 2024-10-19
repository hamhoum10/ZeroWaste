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
}
