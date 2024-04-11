<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'image_path',
        'caption',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
