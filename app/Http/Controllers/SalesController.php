<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SoldSalesRoom;
use App\Building;
use App\Room;
use App\Http\Requests\Rent;

class SalesController extends Controller
{
    /*  
    * 売買バージョンに切り替え(1部屋)
    *　@param $building->id
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
    * @param $room->id
    */
    public function Edit($id)
    {
        $room = Room::find($id);
        $rentData = $room->getRoomSalesVer($id);
        $soldSalesRoom = $rentData['soldSalesRoom'];
        $stockSalesRoom = $rentData['stockSalesRoom'];
        
        return view('rooms.salesEdit',[
            'room' => $room,
            'soldSalesRoom' => $rentData['soldSalesRoom'],
            'stockSalesRoom' => $rentData['stockSalesRoom'],
            ]);
    }
    /*
    * 売買情報編集
    */
    public function Update(Rent $request,$roomId,$stockId = -1,$soldId = -1)
    {
        $request->validated();
        
        //売買在庫更新
        $stockSalesRoom = new StockRentRoom();
        $stockSalesRoomData = $stockSalesRoom->nullSubZero($request);
        if($stockSalesRoomData['price'] !== null || $stockSalesRoomData['previous_price'] !== null || $request->registered_at || $request->changed_at){
            StockSalesRoom::updateOrCreate(
                ['id' => $stockId ],
                [
                    'room_id' => $roomId,
                    'price' => $stockSalesRoomData['price'],
                    'previous_price' => $stockSalesRoomData['previous_price'],
                    'registered_at' => $request->registered_at,
                    'changed_at' => $request->changed_at,
                ]
                );
        }
        //売買成約更新
        $soldSalesRoom = new StockRentRoom();
        $soldSalesRoomData = $soldSalesRoom->nullSubZero($request);
        if($stockSalesRoomData['price'] !== null || $stockSalesRoomData['previous_price'] !== null || $request->sold_registered_at || $request->sold_changed_at){
            SoldSalesRoom::updateOrCreate(
                ['id' => $soldId ],
                [
                    'room_id' => $roomId,
                    'price' => $soldSalesRoomData['sold_price'],
                    'previous_price' => $soldSalesRoomData['sold_previous_price'],
                    'registered_at' => $request->sold_registered_at,
                    'changed_at' => $request->sold_changed_at,
                ]
                );
        }
        //売買バージョンページにリダイレクト
        $buildingId = Room::where('id',$roomId)->value('building_id');
        $building = Building::select('id','building_name')->find($buildingId);
        $rooms = new Room();
        $rooms = $rooms->getForSales($buildingId);
        return view('buildings.sales',compact('rooms','building'));
    }

    public function destroy($stockSalesRoomId = -1,$soldSalesRoomId = -1)
    {
        $soldSalesRoom = SoldSalesRoom::find($soldSalesRoomId);
        $stockSalesRoom = StockSalesRoom::find($stockSalesRoomId);dd($soldSalesRoomId,$soldSalesRoom,$stockSalesRoomId,$stockSalesRoom);
        if($soldSalesRoom){
            $soldSalesRoom->delete();
        }
        if($stockSalesRoom){
            $stockSalesRoom->delete();
        }
        
        //売買バージョンページにリダイレクト
        \Session::flash('flash_message', '売買情報を削除しました');
        return back();
    }

    public function floorSort($id,$floor)
    {
        $building = Building::select('id','building_name')->find($id);
        //全階数取得
        $floor_numbers = [];
        $rooms = new Room();
        $rooms = $rooms->getForSales($id);
        foreach($rooms as $room){
            $floor_numbers[] = $room->floor_number;
        }
        $floor_numbers = array_unique($floor_numbers);

        $rooms = Room::with(['building:id,building_name','soldSalesRooms:id,room_id,price,previous_price,changed_at,registered_at','stockSalesRooms:id,room_id,price,previous_price,changed_at,registered_at','copyOfRegisters:id,room_id,pdf_filename'])
                        ->where('building_id',$id)
                        ->where('floor_number',$floor)
                        ->orderBy('id','asc')
                        ->get();
        
        //最小新築時坪単価
        $expectedUnitPrices = [];
        foreach($rooms as $room){
            if($room->occupied_area != 0){
                $expectedUnitPrices [] = round($room->published_price / ($room->occupied_area * 0.3025));
            }
        }
        $expectedUnitPrice = min($expectedUnitPrices);

        // 最小新築時売買価格
        $publishedPrices = [];
        foreach($rooms as $room){
            if($room->published_price != 0){
                $publishedPrices [] = $room->published_price;
            }
        }
        $publishedPrice = min($publishedPrices);
        
        return view('buildings.salesFloor',compact('rooms','building','floor_numbers','floor','expectedUnitPrice','publishedPrice'));
    }
}
