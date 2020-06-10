<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SoldRentRoom;
use App\StockRentRoom;
use App\Room;
use App\Building;
use App\Http\Requests\Rent;

class RentController extends Controller
{
    /*  
    * 賃貸バージョンに切り替え(全体)
    *　@param $building->id
    */
    public function stocksAll(Request $request,$id)
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
        $expectedUnitRentPrice = $this->minExpectedUnitRentPrice($rooms);//最小予想賃料坪単価
        $expectedRentPrice     = $this->minExpectedRentPrice($rooms);// 最小予想賃料

        return view('rent.rent',compact('rooms','building','expectedUnitRentPrice','expectedRentPrice'));
    }

    /*  
    * 賃貸バージョンに切り替え(1部屋)
    *　@param $room->id
    */
    public function rent($id)
    {
        $room = Room::find($id);
        $salesData = $room->getRoomRentVer($id);
        return view('rooms.rent',[
            'room' => $room,
            'soldRentRoom' => $salesData['soldRentRoom'],
            'stockRentRoom' => $salesData['stockRentRoom'],
            ]);
    }


    /*
    * @param $room->id
    */
    public function Edit($id)
    {
        $room = Room::find($id);
        $rentData = $room->getRoomRentVer($id);
        $soldRentRoom = $rentData['soldRentRoom'];
        $stockRentRoom = $rentData['stockRentRoom'];
        
        return view('rooms.rentEdit',[
            'room' => $room,
            'soldRentRoom' => $rentData['soldRentRoom'],
            'stockRentRoom' => $rentData['stockRentRoom'],
            ]);
    }
    /*
    * 賃貸情報編集
    */
    public function Update(Rent $request,$roomId,$stockId = -1,$soldId = -1)
    {
        $request->validated();
        //在庫賃貸更新
        $stockRentRoom = StockRentRoom::firstOrNew(['id' => $stockId]);
        $stockRentRoomData = $stockRentRoom->nullSubZero($request);
        if($stockRentRoomData['price'] !== null || $stockRentRoomData['previous_price'] !== null || $request->registered_at || $request->changed_at){
            StockRentRoom::updateOrCreate(
                ['id' => $stockId ],
                [
                    'room_id' => $roomId,
                    'price' => $stockRentRoomData['price'],
                    'previous_price' => $stockRentRoomData['previous_price'],
                    'registered_at' => $request->registered_at,
                    'changed_at' => $request->changed_at,
                ]
                );
        }
        //賃貸成約更新
        $soldRentRoom = new StockRentRoom();
        $soldRentRoomData = $soldRentRoom->nullSubZero($request);
        if($soldRentRoomData['sold_price'] !== null || $soldRentRoomData['sold_previous_price'] !== null || $request->sold_registered_at || $request->sold_changed_at){
            SoldRentRoom::updateOrCreate(
                ['id' => $soldId ],
                [
                    'room_id' => $roomId,
                    'price' => $soldRentRoomData['sold_price'],
                    'previous_price' => $soldRentRoomData['sold_previous_price'],
                    'registered_at' => $request->sold_registered_at,
                    'changed_at' => $request->sold_changed_at,
                ]
                );
        }
        //賃貸バージョンページへリダイレクト
        $buildingId = Room::where('id',$roomId)->value('building_id');
        $building = Building::select('id','building_name')->find($buildingId);
        $rooms = new Room();
        $rooms = $rooms->getForRent($buildingId);
        return view('buildings.rent',compact('rooms','building'));
    }

    public function destroy($stockRentRoomId = -1,$soldRentRoomId = -1)
    {
        $soldRentRoom = SoldRentRoom::find($soldRentRoomId);
        $stockRentRoom = StockRentRoom::find($stockRentRoomId);
        if($soldRentRoom){
            $soldRentRoom->delete();
        }
        if($stockRentRoom){
            $stockRentRoom->delete();
        }
        
        //賃貸バージョンページにリダイレクト
        \Session::flash('flash_message', '賃貸情報を削除しました');
        return back();
    }

    /*  
    * 賃貸階数別検索
    *　@param $building->id,$floor_number
    */
    public function floorSort($id,$floor)
    {
        $building = Building::select('id','building_name')->find($id);
        //全階数取得
        $floor_numbers = [];
        $rooms = new Room();
        $rooms = $rooms->getForRent($id);
        foreach($rooms as $room){
            $floor_numbers[] = $room->floor_number;
        }
        $floor_numbers = array_unique($floor_numbers);

        $rooms = Room::with(['building:id,building_name','soldRentRooms:id,room_id,price,previous_price,changed_at,registered_at','stockRentRooms:id,room_id,price,previous_price,changed_at,registered_at','copyOfRegisters:id,room_id,pdf_filename'])
                        ->where('building_id',$id)
                        ->where('floor_number',$floor)
                        ->orderBy('id','asc')
                        ->get();
        
        $expectedUnitRentPrice = $this->minExpectedUnitRentPrice($rooms);//最小予想賃料坪単価
        $expectedRentPrice     = $this->minExpectedRentPrice($rooms);// 最小予想賃料

        return view('rent.floor',compact('rooms','building','floor_numbers','floor','expectedUnitRentPrice','expectedRentPrice'));
    }

    /* 
    * @param $building->id,$layout_type
    *  間取タイプ別検索
    */
    public function layoutTypeSort($id,$layoutType)
    {
        $building = Building::select('id','building_name')->find($id);
        $rooms = Room::with(['building:id,building_name','soldRentRooms:id,room_id,price,previous_price,changed_at,registered_at','stockRentRooms:id,room_id,price,previous_price,changed_at,registered_at','copyOfRegisters:id,room_id,pdf_filename'])
                        ->where('building_id',$id)
                        ->where('layout_type',$layoutType)
                        ->orderBy('id','asc')
                        ->get();
        $layout_type = rtrim($layoutType);
        $expectedUnitRentPrice = $this->minExpectedUnitRentPrice($rooms);//最小予想賃料坪単価
        $expectedRentPrice     = $this->minExpectedRentPrice($rooms);// 最小予想賃料

        return view('rent.layoutType',compact('rooms','building','layout_type','expectedUnitRentPrice','expectedRentPrice'));
    }
    
    public function minExpectedUnitRentPrice($rooms)
    {
        $expectedUnitRentPrices = [];
        foreach($rooms as $room){
            if($room->occupied_area != 0){
                $expectedUnitRentPrices [] = round($room->expected_rent_price / ($room->occupied_area * 0.3025));
            }
        }
        if($expectedUnitRentPrices){
            return min($expectedUnitRentPrices);
        }else{
            return 0;
        }
    }
    
    public function minExpectedRentPrice($rooms)
    {
        $expectedRentPrices = [];
        foreach($rooms as $room){
            if($room->expected_rent_price != 0){
                $expectedRentPrices [] = $room->expected_rent_price;
            }
        }
        if($expectedRentPrices){
            return min($expectedRentPrices);
        }else{
            return 0;
        }
    }
}
