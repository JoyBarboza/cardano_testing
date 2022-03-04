<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
Use DB;

class Env extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'key', 'value'
    ];

    protected $dates = [
        'deleted_at'
    ];

    // public static function createOrUpdate(array $data)
    // {
    //     //$encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
        
    //     DB::table('envs')->where('status',1)->update(['status' => 0]);
    //     foreach ($data as $key => $value) {
    //         $query = Env::where('key', $key);
    //         if($query->exists()) {
    //             $query->update([
    //                 'value' => $value
    //             ]);
    //         }
    //         Env::create(['key' => $key, 'value' => Crypt::encryptString($value)]);
    //     }
    // }
}
