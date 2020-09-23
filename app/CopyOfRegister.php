<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CopyOfRegister extends Model
{
    protected $guarded = ['id'];

    /**
     * この登記簿情報をもつ部屋を取得する
     */
    public function room()
    {
        return $this->belongsTo('App\Room');
    }
}
