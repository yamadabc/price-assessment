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
            $rooms = $rooms->with(['building:id,building_name','soldSalesRooms:id,room_id,price,previous_price,changed_at,registered_at','stockSalesRooms:id,room_id,price,previous_price,changed_at,registered_at','copyOfRegisters:id,room_id,pdf_filename'])->where('building_id',$id)->orderBy('id','asc')->get();
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
            $rooms = $rooms->with(['building:id,building_name','soldRentRooms:id,room_id,price,previous_price,changed_at,registered_at','stockRentRooms:id,room_id,price,previous_price,changed_at,registered_at','copyOfRegisters:id,room_id,pdf_filename'])->where('building_id',$id)->orderBy('id','asc')->get();
        }

        return view('buildings.stocks',compact('rooms','building'));
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
                        ->get();
        $jsRooms = Room::where('building_id',$id)
                        ->where('floor_number',$floor)
                        ->select('occupied_area','published_price','expected_price')
                        ->get();
        
        return view('buildings.floor',compact('jsRooms','rooms','building','floor_numbers','floor'));
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
