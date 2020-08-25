<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockSalesRoom;
use App\StockRentRoom;
use App\Building;
use App\Room;
use App\Http\Requests\Rent;

class StockRentRoomController extends Controller
{
    /**
     * 賃貸在庫情報登録ページ
     * @param int $room->id
     * @return response
     */
    public function create($id)
    {
        $room = Room::find($id);
        return view('stocks.createRent',compact('id','room'));
    }

    /**
     * 賃貸在庫登録
     * @param Rent $request
     * @param int $roomId
     * @return response
     */
    public function store(Rent $request,$roomId)
    {
        $validated = $request->validated();

        $stackRentRoom = new StockRentRoom();
        $stackRentRoomData = [];
        $stackRentRoomData = $stackRentRoom->nullSubZero($request);
        $stackRentRoom::create([
            'room_id'             => $roomId,
            'price'               => $request->price,
            'previous_price'      => $stackRentRoomData['previous_price'],
            'management_fee'      => $stackRentRoomData['management_fee'],
            'monthly_fee'         => $stackRentRoomData['monthly_fee'],
            'security_deposit'    => $stackRentRoomData['security_deposit'],
            'gratuity_fee'        => $stackRentRoomData['gratuity_fee'],
            'deposit'             => $stackRentRoomData['deposit'],
            'company_name'        => $request->company_name,
            'contact_phonenumber' => $request->contact_phonenumber,
            'pic'                 => $request->pic,
            'email'               => $request->email,
            'registered_at'       => $request->registered_at,
            'changed_at'          => $request->changed_at,
        ]);
        \Session::flash('flash_message', '新規賃貸在庫情報を登録しました！');
        $buildingId = Room::where('id',$roomId)->value('building_id');
        return redirect()->route('buildings_show',$buildingId);
    }

}
