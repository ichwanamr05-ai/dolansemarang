<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['tag', 'title', 'body', 'author_name', 'is_flagged'];

    public function replies()
    {
        return $this->hasMany(ThreadReply::class);
    }
}