<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'author_id', 'subject', 'body'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function recipient()
    {
        return $this->hasMany(Recipient::class, 'message_id');
    }

    public function reciever()
    {
        return $this->recipient()->inbox()->with('user')
            ->get()->pluck('user.username')
            ->implode(', ');

    }
}