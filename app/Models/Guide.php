<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $fillable = [
        'badge',
        'title',
        'excerpt',
        'content',
        'author_name',
        'read_time',
        'likes_count',
        'image_url',
    ];
}