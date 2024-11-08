<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteCategory extends Model
{
  use HasFactory;

  // Specify the fillable attributes for mass assignment
  protected $fillable = [
    'name',
    'description', // Include the description field
  ];

  // Define the relationship with RecyclingCenter
  public function recyclingCenters()
  {
    return $this->hasMany(RecyclingCenter::class, 'waste_category_id');
  }
}
