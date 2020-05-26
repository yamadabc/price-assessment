<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Building;
use App\SoldSalesRoom;
use App\Http\Requests\RoomEdit;

class RoomsController extends Controller
{
    public function show($id)
    {
        $building = new Building();
        $room = Room::with('soldSalesRooms')->select('id','building_id','room_number','layout','layout_type','direction','occupied_area','published_price','expected_price','expected_rent_price')->find($id);;
        return view('rooms.show',[
            'building'=>$building->getForRoomsShow($room->building_id),
            'room' => $room,
            ]);
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
        $roomData = [];
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
}
