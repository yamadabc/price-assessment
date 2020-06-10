<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;
use App\Room;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\RentController;

class BuildingsController extends Controller
{
    /* 
    *全建物データ取得
    *
    */
    public function index()
    {
        
        $buildings = Building::getWithRooms();
        return view('welcome',compact('buildings'));
    }
    /* 
    * @param $building->id
    *
    */
    public function show(Request $request,$id)
    {
        $rooms = new Room();
        $building = Building::select('id','building_name')->find($id);
        //部屋番号検索
        $keyword = $request->input('room_number');
        if(!empty($keyword)){
            $query = Room::with('building');
            $query->where('building_id','=',$id);
            $query->where(function ($query) use($keyword) {
                $query->where('room_number',$keyword)->orWhere('room_number','like','%'.$keyword);
            });
            $rooms = $query->orderBy('id','asc')->get();
        }else{
            $rooms = $rooms->getForRoomsShow($id);
        }

        return view('buildings.show',compact('rooms','building'));
    }

    /*  
    * 売買バージョンに切り替え(全体)
    *　@param $building->id
    */
    public function sales(Request $request,$id)
    {
        $rooms = new Room();
        $building = Building::select('id','building_name')->find($id);
        //部屋番号検索
        $keyword = $request->input('room_number');
        if(!empty($keyword)){
            $query = Room::with('building','stockSalesRooms','soldSalesRooms');
            $query->where('building_id','=',$id);
            $query->where(function ($query) use($keyword) {
                $query->where('room_number',$keyword)->orWhere('room_number','like','%'.$keyword);
            });
            $rooms = $query->orderBy('id','asc')->get();
        }else{
            $rooms = $rooms->getForSales($id);
        }

        return view('buildings.sales',compact('rooms','building'));
    }

    /*  
    * 賃貸バージョンに切り替え(全体)
    *　@param $building->id
    */
    public function stocks(Request $request,$id)
    {
        $rooms = new Room();
        $building = Building::select('id','building_name')->find($id);
        //部屋番号検索
        $keyword = $request->input('room_number');
        if(!empty($keyword)){
            $query = Room::with('building','stockRentRooms','soldRentRooms');
            $query->where('building_id','=',$id);
            $query->where(function ($query) use($keyword) {
                $query->where('room_number',$keyword)->orWhere('room_number','like','%'.$keyword);
            });
            $rooms = $query->orderBy('id','asc')->get();
        }else{
            $rooms = $rooms->getForRent($id);
        }

        return view('buildings.rent',compact('rooms','building'));
    }

    /* 
    * @param $building->id,$floor_number
    *  階数別検索
    */
    public function floorSort($id,$floor)
    {
        $building = Building::select('id','building_name')->find($id);
        //全階数取得
        $floor_numbers = [];
        foreach($building->rooms as $room){
            $floor_numbers[] = $room->floor_number;
        }
        $floor_numbers = array_unique($floor_numbers);

        $rooms = Room::with('building:id,building_name','soldSalesRooms:id,room_id,price','copyOfRegisters')
                        ->where('building_id',$id)
                        ->where('floor_number',$floor)
                        ->orderBy('id','asc')
                        ->get();
        $salesController = new SalesController();
        $publishedPrice = $salesController->publishedPrice($rooms);
        $rentController = new RentController();
        $minExpectedRentPrice = $rentController->minExpectedRentPrice($rooms);
        return view('buildings.floor',compact('rooms','building','floor_numbers','floor','publishedPrice','minExpectedRentPrice'));
    }
    /* 
    * @param $building->id,$layout_type
    *  間取タイプ別検索
    */
    public function layoutTypeSort($id,$layoutType)
    {
        $building = Building::select('id','building_name')->find($id);
        $rooms = Room::with('building:id,building_name','soldSalesRooms:id,room_id,price','copyOfRegisters')
                        ->where('building_id',$id)
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
