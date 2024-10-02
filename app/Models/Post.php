<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    // Add this line to allow mass assignment of 'title' and 'content' (if applicable)
    protected $fillable = ['title', 'content']; // Add other fields you need to mass-assign

}
