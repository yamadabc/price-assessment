<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Building;
use App\SoldSalesRoom;

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
}
