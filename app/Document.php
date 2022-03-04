<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'name', 'location', 'status'
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 1);
    }

    // public function scopePhoto($query){
    //     return $query->where('name','PHOTO');
    // }
}
