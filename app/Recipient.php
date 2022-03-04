<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'message_id', 'user_id', 'placeholder',
        'is_read', 'is_starred'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

    public function scopeInbox($query)
    {
        return $query->where('placeholder', 'inbox');
    }

    public function scopeOutbox($query)
    {
        return $query->where('placeholder', 'sent');
    }

    public function scopeTrash($query)
    {
        return $query->where('placeholder', 'trash');
    }

    public function scopeDraft($query)
    {
        return $query->where('placeholder', 'draft');
    }

    public function scopeImportant($query)
    {
        return $query->where('is_starred', 1);
    }

    public function scopeSpam($query)
    {
        return $query->where('placeholder', 'spam');
    }

    public function scopeUnread($query) {
        return $query->where('is_read', 0);
    }
}