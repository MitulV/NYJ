<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'organizer_id',
        'short_description',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'address',
        'city_id', 
        'category_id',
        'status',
        'long_description',
        'terms_and_conditions',
        'age_restrictions',
        'min_age',
        'max_age',
        'additional_info',
        'image1','image2'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class); // Add relationship to City model
    }

    public function eventImages()
    {
        return $this->hasMany(EventImage::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
