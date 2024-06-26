<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeSetting extends Model
{
    use HasFactory;

    protected $table = 'stripe_settings';

    protected $fillable = [
        'user_id',
        'account_id',
        'onboarding_url',
        'details_submitted'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
