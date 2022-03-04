<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NftItem extends Model
{
    protected $fillable = [
        'id', 'nft_img','created_at','updated_at'
    ];
}
