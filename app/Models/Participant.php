<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['user_name', 'user_email', 'event_id','event_name'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
