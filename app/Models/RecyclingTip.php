<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecyclingTip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'posted_by',
        'likes_count',
        'approved',
        'date_posted'
    ];

    // Relationship to the User model (assuming a user table exists)
    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'tip_likes');
    }
}
