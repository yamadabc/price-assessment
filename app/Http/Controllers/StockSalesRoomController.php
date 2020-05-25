<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockSalesRoom;
use App\Building;
use App\Room;
use App\Http\Requests\Sales;

class StockSalesRoomController extends Controller
{
    /*
    * @param $room->id 
    */
    public function create($id)
    {
        $room = Room::find($id);
        return view('stocks.createSales',compact('id','room'));
    }
    
    public function store(Sales $request,$id)
    {
        $validated = $request->validated();

        $stackSalesRoom = new StockSalesRoom();
        $stackSalesRoomData = [];
        $stackSalesRoomData = $stackSalesRoom->nullSubZero($request);
        $stackSalesRoom::create([
            'room_id' => $id,
            'price' => $request->price,
            'previous_price' => $stackSalesRoomData['previous_price'],
            'management_fee' => $stackSalesRoomData['management_fee'],
            'reserve_fund' => $stackSalesRoomData['reserve_fund'],
            'company_name' => $request->company_name,
            'pic' => $request->pic,
            'email' => $request->email,
            'registered_at' => $request->registered_at,
            'changed_at' => $request->changed_at,
        ]);
        $builings = Building::getWithRooms();
        \Session::flash('flash_message', '新規売買在庫を登録しました！');
        return view('welcome',['buildings' => $builings]);
    }

}
