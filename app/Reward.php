<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Reward extends Authenticatable
{
    // use Notifiable;
    // use EntrustUserTrait { restore as private restoreA;}
    // use SoftDeletes { restore as private restoreB;}

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'time', 'reward','total_user',
        'created_at'
    ];

}
