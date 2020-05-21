<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockSalesRoom extends Model
{
    protected $guarded = ['id'];

    public function room()
    {
        return $this->belongsTo('App\Room');
    }
}
