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
        'details_submitted',
        'account_json'
    ];

    protected $casts = [
        'account_json' => 'array'
    ];

    /**
     * Get the user that owns the stripe setting.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
