<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecyclingCenter extends Model
{
  use HasFactory;

  // Specify the table name if it differs from the pluralized model name
  protected $table = 'recycling_centers';

  // Specify the fillable attributes
  protected $fillable = [
    'name',
    'address',
    'phone',
    'waste_category_id',
    'latitude',  // Add latitude to fillable attributes
    'longitude', // Add longitude to fillable attributes
  ];

  // Define the relationship with the WasteCategory model
  public function wasteCategory()
  {
    return $this->belongsTo(WasteCategory::class, 'waste_category_id');
  }
}
