<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'building_id',
        'room_number',
        'floor_number',
        'layout',
        'direction',
        'occupied_area',
        'balcony_area',
        'roof_balcony_area',
        'terass_area',
        'garden_area',
        'residential_building_name',
        'layout_type',
        'published_price',
        'expected_price',
        'expected_rent_price',
    ];

    public function building()
    {
        return $this->belongsTo('App\Building');
    }

    public function stockSalesRooms()
    {
        return $this->hasMany('App\StockSalesRoom');
    }
    public function stockRentRooms()
    {
        return $this->hasMany('App\StockRentRoom');
    }
    public function soldSalesRooms()
    {
        return $this->hasMany('App\SoldSalesRoom');
    }
    public function soldRentRooms()
    {
        return $this->hasMany('App\SoldRentRoom');
    }
    public function copyOfRegisters()
    {
        return $this->hasMany('App\CopyOfRegister');
    }

    
}
