<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockSalesRoom;
use App\Building;
use App\Room;
use App\Http\Requests\Sales;

class StockSalesRoomController extends Controller
{
    /**
     * 売買在庫情報登録ページ
     * @param int $room->id
     * @return reponse
     */
    public function create($id)
    {
        $room = Room::find($id);
        return view('stocks.createSales',compact('id','room'));
    }
    /**
     * 売買在庫登録
     * @param Sales $request
     * @param int $roomId
     * @return response
     */
    public function store(Sales $request,$roomId)
    {
        $validated = $request->validated();

        $stackSalesRoom = new StockSalesRoom();
        $stackSalesRoomData = [];
        $stackSalesRoomData = $stackSalesRoom->nullSubZero($request);
        $stackSalesRoom::create([
            'room_id' => $roomId,
            'price' => $request->price,
            'previous_price' => $stackSalesRoomData['previous_price'],
            'management_fee' => $stackSalesRoomData['management_fee'],
            'reserve_fund' => $stackSalesRoomData['reserve_fund'],
            'company_name' => $request->company_name,
            'contact_phonenumber'     => $request->contact_phonenumber,
            'pic' => $request->pic,
            'email' => $request->email,
            'registered_at' => $request->registered_at,
            'changed_at' => $request->changed_at,
        ]);
        \Session::flash('flash_message', '新規売買在庫を登録しました！');
        $buildingId = Room::where('id',$roomId)->value('building_id');
        return redirect()->route('buildings_show',$buildingId);
    }

}
