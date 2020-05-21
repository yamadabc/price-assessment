<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoldRentRoom extends Model
{
    protected $guarded = ['id'];

    public function room()
    {
        return $this->belongsTo('App\Room');
    }
}
