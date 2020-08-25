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
    /**
     * @param int
     * @return redirect
     */
    public function store(RoomEdit $request,$buildingId)
    {
        $request->validated();

        $room = new Room();
        $building = Building::find($buildingId);

        $building->rooms()->create([
            'room_number' => $request->room_number,
            'floor_number' => $request->floor_number,
            'layout' => $request->layout,
            'layout_type' => $request->layout_type,
            'direction' => $request->direction,
            'occupied_area' => $request->occupied_area,
            'published_price' => $request->published_price,
            'expected_price' => $request->expected_price,
            'expected_rent_price' => $request->expected_rent_price,
            'has_no_data' => $request->has_no_data,
        ]);
        \Session::flash('flash_message', '部屋情報を登録しました');
        return redirect()->route('buildings_show',$buildingId);

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
        $room->update([
            'room_number' => $request->room_number,
            'floor_number' => $request->floor_number,
            'layout' => $request->layout,
            'layout_type' => $request->layout_type,
            'direction' => $request->direction,
            'occupied_area' => $request->occupied_area,
            'published_price' => $request->published_price,
            'expected_price' => $request->expected_price,
            'expected_rent_price' => $request->expected_rent_price,
        ]);

        \Session::flash('flash_message', '部屋情報を編集しました');
        return view('rooms.show',compact('room'));
    }


}
