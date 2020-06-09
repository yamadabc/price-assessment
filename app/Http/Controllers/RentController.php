<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SoldRentRoom;
use App\StockRentRoom;
use App\Room;
use App\Building;
use App\Http\Requests\Rent;

class RentController extends Controller
{

    /*  
    * 賃貸バージョンに切り替え(1部屋)
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
    public function Edit($id)
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
    public function Update(Rent $request,$roomId,$stockId = -1,$soldId = -1)
    {
        $request->validated();
        //在庫賃貸更新
        $stockRentRoom = StockRentRoom::firstOrNew(['id' => $stockId]);
        $stockRentRoomData = $stockRentRoom->nullSubZero($request);
        if($stockRentRoomData['price'] !== null || $stockRentRoomData['previous_price'] !== null || $request->registered_at || $request->changed_at){
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
        //賃貸成約更新
        $soldRentRoom = new StockRentRoom();
        $soldRentRoomData = $soldRentRoom->nullSubZero($request);
        if($soldRentRoomData['sold_price'] !== null || $soldRentRoomData['sold_previous_price'] !== null || $request->sold_registered_at || $request->sold_changed_at){
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
        //賃貸バージョンページへリダイレクト
        $buildingId = Room::where('id',$roomId)->value('building_id');
        $building = Building::select('id','building_name')->find($buildingId);
        $rooms = new Room();
        $rooms = $rooms->getForRent($buildingId);
        return view('buildings.rent',compact('rooms','building'));
    }

    public function destroy($stockRentRoomId = -1,$soldRentRoomId = -1)
    {
        $soldRentRoom = SoldRentRoom::find($soldRentRoomId);
        $stockRentRoom = StockRentRoom::find($stockRentRoomId);
        if($soldRentRoom){
            $soldRentRoom->delete();
        }
        if($stockRentRoom){
            $stockRentRoom->delete();
        }
        
        //賃貸バージョンページにリダイレクト
        \Session::flash('flash_message', '賃貸情報を削除しました');
        return back();
    }
}
