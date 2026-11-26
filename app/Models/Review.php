<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'destination_id',
        'user_name',
        'rating',
        'rating_scenery',
        'rating_access',
        'rating_cleanliness',
        'rating_facilities',
        'comment',
        'photo_url',
        'visit_period',
        'crowd_status',
        'helpful_count',
        'is_flagged',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}