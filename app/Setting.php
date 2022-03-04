<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key', 'value'
    ];


    public function getMeta($key)
    {
        $query = $this->where('key', $key);

        return $query->exists()?$query->first()->value:0;
    }

    public function setMeta($key, $value)
    {
        $setting = $this->firstOrCreate(['key' => $key]);

        $setting->value = $value;

        return $setting->save();
    }

    public function updateMeta($key,$value){

        $this->where('key', $key)
          ->update(['value' => $value]);
    }
}
