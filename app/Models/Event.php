<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $primaryKey = 'event_id';

    protected $fillable = [
        'event_name',
        'description',
        'location',
        'start_date',
        'end_date',
        'event_image',
        'reservation_limit',
        
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public function participants()
{
    return $this->hasMany(Participant::class, 'event_id');
}
}
