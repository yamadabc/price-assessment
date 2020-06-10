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
    * @param int $building->id
    *
    */
    public function create($id)
    {
        $building = Building::find($id);
        return view('rooms.create',[
            'building' => $building,
        ]);
    }
    /*
    * @param int $building->id
    *
    */
    public function store(RoomEdit $request,$id)
    {
        $request->validated();

        $room = new Room();
        $roomData = $room->nullSubZero($request);
        $building = Building::find($id);
        
        $building->rooms()->create([
            'room_number' => $request->room_number,
            'floor_number' => $request->floor_number,
            'layout' => $request->layout,
            'layout_type' => $request->layout_type,
            'direction' => $request->direction,
            'occupied_area' => $roomData['occupied_area'],
            'published_price' => $roomData['published_price'],
            'expected_price' => $roomData['expected_price'],
            'expected_rent_price' => $roomData['expected_rent_price'],
            'has_no_data' => $request->has_no_data,
        ]);
        \Session::flash('flash_message', '部屋情報を登録しました');
        return redirect()->route('buildings_show',$id);
        
    }
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

        \Session::flash('flash_message', '部屋情報を編集しました');
        return view('rooms.show',compact('room'));
    }


}
