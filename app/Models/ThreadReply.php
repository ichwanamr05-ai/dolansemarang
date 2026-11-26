<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThreadReply extends Model
{
    protected $fillable = ['thread_id', 'author_name', 'reply_text'];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}