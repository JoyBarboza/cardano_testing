<?php

// namespace App;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
// use DB;

// class UserBuyPack extends Model
// {
//     use SoftDeletes;

//     const BASE_PRICE = 0.15;

//     protected $fillable = [
//     ];

//     // protected $dates = [
//     //     'deleted_at'
//     // ];

// }


namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBuyPack extends Model
{
    protected $fillable = [
        'id', 'type	','user_id','pack_id','created_at','updated_at','deleted_at'
    ];
}

