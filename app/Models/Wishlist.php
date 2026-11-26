<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['destination_id', 'user_name', 'status'];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}