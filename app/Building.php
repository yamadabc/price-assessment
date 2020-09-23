<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = [
        'building_name',
        'prefecture',
        'city',
        'street',
        'built_year',
        'built_month',
        'total_unit',
        'layout',
        'occupied_area',
        'construction',
        'construction_company',
        'seller',
        'parking',
        'kindergarten_district',
        'primary_school_district',
        'middle_school_district',
        'station_route_01',
        'station_name_01',
        'station_walk_01',
        'station_route_02',
        'station_name_02',
        'station_walk_02',
        'station_route_03',
        'station_name_03',
        'station_walk_03',
    ];

    public function rooms()
    {
        return $this->hasMany('App\Room');
    }
    //building@index
    public static function getWithRooms()
    {
        return self::with('rooms:id,building_id,published_price,expected_price,expected_rent_price,occupied_area')->orderBy('id')->select('id','building_name','total_unit')->get();
    }

    /**
     * 物件の査定終了部屋数をカウント
     * @return int
     */
    public function countExpectedPrice()
    {
        $expectedPriceCount = 0;

        foreach($this->rooms as $room){
            if(empty($room->expected_price)){
                continue;
            }
            $expectedPriceCount ++;
        }
        return $expectedPriceCount;
    }

    /**
     * 物件の新築時価格あり戸数をカウント
     * @return int
     */
    public function countPublishedPrice()
    {
        $publishedPriceCount = 0;
        foreach($this->rooms as $room){
            if(empty($room->published_price)){
                continue;
            }
            $publishedPriceCount ++;
        }
        return $publishedPriceCount;
    }

}
