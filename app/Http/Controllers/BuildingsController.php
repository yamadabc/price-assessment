<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;
use App\Room;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\RentController;
use App\Library\BaseClass;

class BuildingsController extends Controller
{
    /**
     * 全物件データ取得
     */
    public function index()
    {
        $buildings = Building::getWithRooms();
        $baseClass = new BaseClass();
        return view('welcome',compact('buildings','baseClass'));
    }

    /**
     * 物件ごとのtop(テーブル表示)
     * @param int $buildingId
     * @return response
     */
    public function show(Request $request,$buildingId)
    {
        $rooms = new Room();
        $building = Building::with(['rooms' => function($query){
            $query->where('expected_price','>',0);
        }])->select('id','building_name','total_unit')->find($buildingId);
        //部屋番号検索
        $keyword = $request->input('room_number');
        if(!empty($keyword)){
            $query = Room::with('building');
            $query->where('building_id','=',$buildingId);
            $query->where(function ($query) use($keyword) {
                $query->where('room_number',$keyword)->orWhere('room_number','like','%'.$keyword);
            });
            $rooms = $query->orderBy('id','asc')->get();
        }else{
            $rooms = $rooms->getForRoomsShow($buildingId);
        }
        //散布図用
        $salesController = new SalesController();
        $publishedPrice = $salesController->publishedPrice($rooms);
        $rentController = new RentController();
        $minExpectedRentPrice = $rentController->minExpectedRentPrice($rooms);

        return view('buildings.show',compact('rooms','building','publishedPrice','minExpectedRentPrice'));
    }

    /**
     * 物件ごとのtop(スタッキング表示)
     * @param int $buildingId
     * @return response
     */
    public function stucking($buildingId)
    {
        $building = Building::with(['rooms' => function($query){
            $query->where('expected_price','>',0);
        }])->select('id','building_name','total_unit')->find($buildingId);

        $floorNumbers = Room::where('building_id',$buildingId)
                        ->select('floor_number')
                        ->groupBy('floor_number')
                        ->orderBy('floor_number','desc')
                        ->get();
        return view('buildings.stucking',compact('building','floorNumbers'));
    }
    /**
     *  階数別検索
     * @param $buildingId,$floor_number
     * @return response
     */
    public function floorSort($buildingId,$floor)
    {
        $building = Building::with(['rooms' => function($query){
            $query->where('expected_price','>',0);
        }])->select('id','building_name','total_unit')->find($buildingId);
        //全階数取得
        $floor_numbers = [];
        foreach($building->rooms as $room){
            $floor_numbers[] = $room->floor_number;
        }
        $floor_numbers = array_unique($floor_numbers);

        $rooms = Room::with('building:id,building_name','soldSalesRooms:id,room_id,price','copyOfRegisters')
                        ->where('building_id',$buildingId)
                        ->where('floor_number',$floor)
                        ->orderBy('id','asc')
                        ->get();
        $salesController = new SalesController();
        $publishedPrice = $salesController->publishedPrice($rooms);
        $rentController = new RentController();
        $minExpectedRentPrice = $rentController->minExpectedRentPrice($rooms);

        return view('buildings.floor',compact('rooms','building','floor_numbers','floor','publishedPrice','minExpectedRentPrice'));
    }
    /**
     * 間取タイプ別検索
     * @param $buildingId,$layout_type
     */
    public function layoutTypeSort($buildingId,$layoutType)
    {
        $building = Building::with(['rooms' => function($query){
            $query->where('expected_price','>',0);
        }])->select('id','building_name','total_unit')->find($buildingId);
        $rooms = Room::with('building:id,building_name','soldSalesRooms:id,room_id,price','copyOfRegisters')
                        ->where('building_id',$buildingId)
                        ->where('layout_type',$layoutType)
                        ->orderBy('id','asc')
                        ->get();
        $salesController = new SalesController();
        $publishedPrice = $salesController->publishedPrice($rooms);
        $rentController = new RentController();
        $minExpectedRentPrice = $rentController->minExpectedRentPrice($rooms);
        $layout_type = rtrim($layoutType);

        return view('buildings.layoutType',compact('rooms','building','layout_type','publishedPrice','minExpectedRentPrice'));
    }

}
