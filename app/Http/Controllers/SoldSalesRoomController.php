<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\SoldSalesRoom;
use App\StockSalesRoom;
use App\Building;
use App\Http\Requests\Sales;


class SoldSalesRoomController extends Controller
{
    /**
     * 売買成約情報登録ページ
     * @param int $id
     * @return response
     */
    public function create($id)
    {
        $room = Room::find($id);
        return view('sold.createSales',compact('id','room'));
    }
    /**
     * 売買成約情報登録
     * @param Sales $request
     * @param int $roomId
     * @return response
     */
    public function store(Sales $request,$roomId)
    {
        $validated = $request->validated();

        $soldSalesRoom = new StockSalesRoom();
        $soldSalesRoomData = [];
        $soldSalesRoomData = $soldSalesRoom->nullSubZero($request);
        SoldSalesRoom::create([
            'room_id' => $roomId,
            'price' => $request->price,
            'previous_price' => $soldSalesRoomData['previous_price'],
            'management_fee' => $soldSalesRoomData['management_fee'],
            'reserve_fund' => $soldSalesRoomData['reserve_fund'],
            'company_name' => $request->company_name,
            'contact_phonenumber'     => $request->contact_phonenumber,
            'pic' => $request->pic,
            'email' => $request->email,
            'registered_at' => $request->registered_at,
            'changed_at' => $request->changed_at,
        ]);
        \Session::flash('flash_message', '新規売買成約情報を登録しました！');
        $buildingId = Room::where('id',$roomId)->value('building_id');
        return redirect()->route('buildings_show',$buildingId);
    }
}
