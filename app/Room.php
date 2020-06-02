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

    //rooms@sales
    public function getRoomSalesVer($id)
    {
        $soldSalesRoom  = $this::find($id)->soldSalesRooms()->orderBy('created_at','desc')->first();
        $stockSalesRoom = $this::find($id)->stockSalesRooms()->orderBy('created_at','desc')->first();

        return [
            'soldSalesRoom'  => $soldSalesRoom,
            'stockSalesRoom' => $stockSalesRoom,
        ];
    }
    //rooms@rent
    public function getRoomRentVer($id)
    {
        $soldRentRoom  = $this::find($id)->soldRentRooms()->orderBy('created_at','desc')->first();
        $stockRentRoom = $this::find($id)->stockRentRooms()->orderBy('created_at','desc')->first();

        return [
            'soldRentRoom'  => $soldRentRoom,
            'stockRentRoom' => $stockRentRoom,
        ];
    }
    //building@show
    public function getForRoomsShow($id)
    {
        return $this->with(['building:id,building_name','soldSalesRooms:id,room_id,price','copyOfRegisters:id,room_id,pdf_filename'])->where('building_id',$id)->orderBy('id','asc')->get();
    }
    //rooms@show
    public function getForRoomsShowRoomId($id)
    {
        return $this->with(['soldSalesRooms:id,room_id,price','copyOfRegisters:id,room_id,pdf_filename'])->find($id);
    }
    //nullなら0を代入
    public function nullSubZero($request)
    {
        if($request->occupied_area === null){
            $occupied_area = 0;
        }else{
            $occupied_area = $request->occupied_area;
        }
        
        if($request->published_price === null){
            $published_price = 0;
        }else{
            $published_price = $request->published_price;
        }
        
        if($request->expected_price === null){
            $expected_price = 0;
        }else{
            $expected_price = $request->expected_price;
        }
        
        if($request->expected_rent_price === null){
            $expected_rent_price = 0;
        }else{
            $expected_rent_price = $request->expected_rent_price;
        }

        return [
            'occupied_area' => $occupied_area,
            'published_price' => $published_price,
            'expected_price' => $expected_price,
            'expected_rent_price' => $expected_rent_price,
        ];
    }

    public function getCopyOfRegisters($id)
    {
        $end = $this->copyOfRegisters;
        foreach($this->copyOfRegisters as $copyOfRegister){
            if(!next($end)){
                return $copyOfRegister->where('room_id',$id)->latest()->value('id');
            }
        }
    }

}
