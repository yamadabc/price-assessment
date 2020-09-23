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
        'has_no_data',
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

    /**
     * 最新の売買の在庫情報と成約情報を取得
     * @param int $id
     * @return object[]
     */
    public function getRoomSalesVer($id)
    {
        $soldSalesRoom  = $this::find($id)->soldSalesRooms()->orderBy('created_at','desc')->first();
        $stockSalesRoom = $this::find($id)->stockSalesRooms()->orderBy('created_at','desc')->first();

        return [
            'soldSalesRoom'  => $soldSalesRoom,
            'stockSalesRoom' => $stockSalesRoom,
        ];
    }
    /**
     * この部屋の最新の賃貸の在庫情報と成約情報を取得
     * @param int $room_id
     * @return object[]
     */
    public function getRoomRentVer($room_id)
    {
        $soldRentRoom  = $this::find($room_id)->soldRentRooms()->orderBy('created_at','desc')->first();
        $stockRentRoom = $this::find($room_id)->stockRentRooms()->orderBy('created_at','desc')->first();

        return [
            'soldRentRoom'  => $soldRentRoom,
            'stockRentRoom' => $stockRentRoom,
        ];
    }
    /**
     * 該当物件の部屋情報を物件idから取得
     * @param int $building_id
     * @return object
     */
    public function getForRoomsShow($id)
    {
        return $this->with(['building:id,building_name','soldSalesRooms:id,room_id,price','copyOfRegisters:id,room_id,pdf_filename'])->where('building_id',$id)->orderBy('id','asc')->get();
    }
    /**
     * この部屋の情報を売買成約情報と登記簿情報と共に取得
     * @param int $room_id
     * @return object
     */
    public function getForRoomsShowRoomId($id)
    {
        return $this->with(['soldSalesRooms:id,room_id,price','copyOfRegisters:id,room_id,pdf_filename'])->find($id);
    }

    /**
     * この部屋の情報を売買情報メインで取得
     * @param int $id
     * @param object
     */
    public function getForSales($id)
    {
        return $this->with(['building:id,building_name','soldSalesRooms:id,room_id,price,previous_price,changed_at,registered_at','stockSalesRooms:id,room_id,price,previous_price,changed_at,registered_at','copyOfRegisters:id,room_id,pdf_filename'])->where('building_id',$id)->orderBy('id','asc')->get();
    }
    /**
     * この部屋の情報を賃貸情報メインで取得
     * @param int $building_id
     * @param object
     */
    public function getForRent($id)
    {
        return $this->with(['building:id,building_name','soldRentRooms:id,room_id,price,previous_price,changed_at,registered_at','stockRentRooms:id,room_id,price,previous_price,changed_at,registered_at','copyOfRegisters:id,room_id,pdf_filename'])->where('building_id',$id)->orderBy('id','asc')->get();
    }
    /**
     * nullなら0を代入
     * @param Request $request
     * @return int[]
     */
    public function nullSubZero($request)
    {
        if($request->occupied_area === null){
            $occupied_area = "";
        }else{
            $occupied_area = $request->occupied_area;
        }

        if($request->published_price === null){
            $published_price = "";
        }else{
            $published_price = $request->published_price;
        }

        if($request->expected_price === null){
            $expected_price = "";
        }else{
            $expected_price = $request->expected_price;
        }

        if($request->expected_rent_price === null){
            $expected_rent_price = "";
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

    /**
     * この部屋の最新の登記簿謄本を取得
     * @param int $id
     * @return int
     */
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
