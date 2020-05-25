<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SoldRentRoom;
use App\StockRentRoom;
use App\Building;
use App\Room;
use App\Http\Requests\Rent;

class SoldRentRoomController extends Controller
{
    /*
    * @param $room->id 
    */
    public function create($id)
    {
        $room = Room::find($id);
        return view('sold.createRent',compact('id','room'));
    }

    public function store(Rent $request,$id)
    {
        $validated = $request->validated();

        $soldRentRoom = new StockRentRoom();
        $soldRentRoomData = [];
        $soldRentRoomData = $soldRentRoom->nullSubZero($request);
        SoldRentRoom::create([
            'room_id'             => $id,
            'price'               => $request->price,
            'previous_price'      => $soldRentRoomData['previous_price'],
            'management_fee'      => $soldRentRoomData['management_fee'],
            'monthly_fee'         => $soldRentRoomData['monthly_fee'],
            'security_deposit'    => $soldRentRoomData['security_deposit'],
            'gratuity_fee'        => $soldRentRoomData['gratuity_fee'],
            'deposit'             => $soldRentRoomData['deposit'],
            'company_name'        => $request->company_name,
            'contact_phonenumber' => $request->contact_phonenumber,
            'pic'                 => $request->pic,
            'email'               => $request->email,
            'registered_at'       => $request->registered_at,
            'changed_at'          => $request->changed_at,
        ]);
        $builings = Building::getWithRooms();
        \Session::flash('flash_message', '新規賃貸成約情報を登録しました！');
        return view('welcome',['buildings' => $builings]);
    }
}
