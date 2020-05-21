<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CopyOfRegister extends Model
{
    protected $guarded = ['id'];

    public function room()
    {
        return $this->belongsTo('App\Room');
    }
}
