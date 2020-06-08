<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Building;
use App\SoldRentRoom;
use App\SoldSalesRoom;
use App\StockRentRoom;
use App\StockSalesRoom;
use App\Http\Requests\RoomEdit;
use App\Http\Requests\Rent;

class RoomsController extends Controller
{
    /*
    *@param $room->id
    *
    */
    public function show($id)
    {
        $room = new Room();
        $room = $room->getForRoomsShowRoomId($id);
        return view('rooms.show',compact('room'));
            
    }
    /*  
    * 売買バージョンに切り替え(1部屋)
    *　@param $building->id
    */
    public function sales($id)
    {
        $room = Room::find($id);
        $salesData = $room->getRoomSalesVer($id);
        return view('rooms.sales',[
            'room' => $room,
            'soldSalesRoom' => $salesData['soldSalesRoom'],
            'stockSalesRoom' => $salesData['stockSalesRoom'],
            ]);
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
    public function edit($id)
    {
        $room = Room::find($id);
        $rentData = $room->getRoomRentVer($id);
        $soldRentRoom = $rentData['soldRentRoom'];
        $stockRentRoom = $rentData['stockRentRoom'];
        $rentData = $room->getRoomSalesVer($id);
        $soldSalesRoom = $rentData['soldSalesRoom'];
        $stockSalesRoom = $rentData['stockSalesRoom'];

        return view('rooms.edit',compact('room','soldRentRoom','stockRentRoom','soldSalesRoom','stockSalesRoom'));
    }

    public function update(RoomEdit $request,$id)
    {
        $request->validated();
        $room = Room::find($id);
        $roomData = $room->nullSubZero($request);

        $room->update([
            'room_number' => $request->room_number,
            'floor_number' => $request->floor_number,
            'layout' => $request->layout,
            'layout_type' => $request->layout_type,
            'direction' => $request->direction,
            'occupied_area' => $roomData['occupied_area'],
            'published_price' => $roomData['published_price'],
            'expected_price' => $roomData['expected_price'],
            'expected_rent_price' => $roomData['expected_rent_price'],
        ]);

        \Session::flash('flash_message', '部屋情報を編集しました！');
        return view('rooms.show',compact('room'));
    }

    /*
    * @param $room->id
    */
    public function rentEdit($id)
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
    public function rentUpdate(Rent $request,$roomId,$stockId = -1,$soldId = -1)
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

    /*
    * @param $room->id
    */
    public function salesEdit($id)
    {
        $room = Room::find($id);
        $rentData = $room->getRoomSalesVer($id);
        $soldSalesRoom = $rentData['soldSalesRoom'];
        $stockSalesRoom = $rentData['stockSalesRoom'];
        
        return view('rooms.salesEdit',[
            'room' => $room,
            'soldSalesRoom' => $rentData['soldSalesRoom'],
            'stockSalesRoom' => $rentData['stockSalesRoom'],
            ]);
    }
    /*
    * 売買情報編集
    */
    public function salesUpdate(Rent $request,$roomId,$stockId = -1,$soldId = -1)
    {
        $request->validated();
        
        //売買在庫更新
        $stockSalesRoom = new StockRentRoom();
        $stockSalesRoomData = $stockSalesRoom->nullSubZero($request);
        if($stockSalesRoomData['price'] !== null || $stockSalesRoomData['previous_price'] !== null || $request->registered_at || $request->changed_at){
            StockSalesRoom::updateOrCreate(
                ['id' => $stockId ],
                [
                    'room_id' => $roomId,
                    'price' => $stockSalesRoomData['price'],
                    'previous_price' => $stockSalesRoomData['previous_price'],
                    'registered_at' => $request->registered_at,
                    'changed_at' => $request->changed_at,
                ]
                );
        }
        //売買成約更新
        $soldSalesRoom = new StockRentRoom();
        $soldSalesRoomData = $soldSalesRoom->nullSubZero($request);
        if($stockSalesRoomData['price'] !== null || $stockSalesRoomData['previous_price'] !== null || $request->sold_registered_at || $request->sold_changed_at){
            SoldSalesRoom::updateOrCreate(
                ['id' => $soldId ],
                [
                    'room_id' => $roomId,
                    'price' => $soldSalesRoomData['sold_price'],
                    'previous_price' => $soldSalesRoomData['sold_previous_price'],
                    'registered_at' => $request->sold_registered_at,
                    'changed_at' => $request->sold_changed_at,
                ]
                );
        }
        //売買バージョンページにリダイレクト
        $buildingId = Room::where('id',$roomId)->value('building_id');
        $building = Building::select('id','building_name')->find($buildingId);
        $rooms = new Room();
        $rooms = $rooms->getForSales($buildingId);
        return view('buildings.sales',compact('rooms','building'));
    }

}
