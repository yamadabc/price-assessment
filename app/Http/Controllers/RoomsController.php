<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Building;
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
    * 売買バージョンに切り替え
    *　@param $room->id
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
    * 賃貸バージョンに切り替え
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
        return view('rooms.edit',[
            'room' => $room,
            ]);
    }

    public function update(RoomEdit $request,$id)
    {
        $request->validated();
        $room = Room::find($id);
        $roomData = $room->nullSubZero($request);

        Room::find($id)->update([
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

        $builings = Building::getWithRooms();
        \Session::flash('flash_message', '部屋情報を編集しました！');
        return view('welcome',['buildings' => $builings]);
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
        if(!empty($stockRentRoomData['price']) || !empty($stockRentRoomData['previous_price']) || $request->registered_at || $request->changed_at){
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
        //売買賃貸更新
        $soldRentRoom = new StockRentRoom();
        $soldRentRoomData = $soldRentRoom->nullSubZero($request);
        if(!empty($soldRentRoomData['sold_price']) || !empty($soldRentRoomData['sold_previous_price']) || $request->sold_registered_at || $request->sold_changed_at){
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
        $builings = Building::getWithRooms();
        return view('welcome',['buildings' => $builings]);
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
    * 賃貸情報編集
    */
    public function salesUpdate(Rent $request,$roomId,$stockId = -1,$soldId = -1)
    {
        $request->validated();
        //在庫賃貸更新
        $stockSalesRoom = new StockRentRoom();
        $stockSalesRoomData = $stockSalesRoom->nullSubZero($request);
        if(!empty($stockSalesRoomData['price']) || !empty($stockSalesRoomData['previous_price']) || $request->registered_at || $request->changed_at){
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
        //売買賃貸更新
        $soldSalesRoom = new StockRentRoom();
        $soldSalesRoomData = $soldSalesRoom->nullSubZero($request);
        if(!empty($soldSalesRoomData['sold_price']) || !empty($soldSalesRoomData['sold_previous_price']) || $request->sold_registered_at || $request->sold_changed_at){
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
        $builings = Building::getWithRooms();
        return view('welcome',['buildings' => $builings]);
    }

}
