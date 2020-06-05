<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;
use App\Room;

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
    * @param $building->id,$floor_number
    *  階数別検索
    */
    public function floorSort($id,$floor)
    {
        $building = Building::select('id','building_name')->find($id);
        $rooms = Room::with('building:id,building_name','soldSalesRooms:id,room_id,price','copyOfRegisters')
                        ->where('building_id',$id)
                        ->where('floor_number',$floor)
                        ->get();
        $jsRooms = Room::where('building_id',$id)
                        ->where('floor_number',$floor)
                        ->select('occupied_area','published_price','expected_price')
                        ->get();
        return view('buildings.floor',compact('jsRooms','rooms','building'));
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
                        ->get();
        $jsRooms = Room::where('building_id',$id)
                        ->where('layout_type',$layoutType)
                        ->select('occupied_area','published_price','expected_price','floor_number')
                        ->get();
        $layout_type = rtrim($layoutType);
        return view('buildings.layoutType',compact('jsRooms','rooms','building','layout_type'));
    }
    
}
