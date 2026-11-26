<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price_range',
        'budget_tier',
        'estimated_cost',
        'best_time',
        'opening_hours',
        'description',
        'address',
        'area',
        'image_url',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}