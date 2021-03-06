<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SoldSalesRoom;
use App\Building;
use App\Room;
use App\StockRentRoom;
use App\StockSalesRoom;
use App\Http\Requests\Rent;

class SalesController extends Controller
{
    /**
     * 売買バージョンに切り替え(全体)
     * @param Request $request
     * @param int $buildingId
     * @return response
     */
    public function salesAll(Request $request,$buildingId)
    {
        $rooms = new Room();
        $building = Building::with(['rooms' => function($query){
            $query->where('expected_price','>',0);
        }])->select('id','building_name','total_unit')->find($buildingId);
        //部屋番号検索
        $keyword = $request->input('room_number');
        if(!empty($keyword)){
            $query = Room::with('building','stockSalesRooms','soldSalesRooms');
            $query->where('building_id','=',$buildingId);
            $query->where(function ($query) use($keyword) {
                $query->where('room_number',$keyword)->orWhere('room_number','like','%'.$keyword);
            });
            $rooms = $query->orderBy('id','asc')->get();
        }else{
            $rooms = $rooms->getForSales($buildingId);
        }
        $publishedUnitPrice = $this->publishedUnitPrice($rooms);//最小新築時坪単価
        $publishedPrice     = $this->publishedPrice($rooms);// 最小新築時売買価格
        return view('buildings.sales',compact('rooms','building','publishedUnitPrice','publishedPrice'));
    }
    /**
     * 売買バージョンに切り替え(1部屋)
     * @param int $buildingId
     * @return response
     */
    public function sales($buildingId)
    {
        $room = Room::find($buildingId);
        $salesData = $room->getRoomSalesVer($buildingId);

        return view('rooms.sales',[
            'room' => $room,
            'soldSalesRoom' => $salesData['soldSalesRoom'],
            'stockSalesRoom' => $salesData['stockSalesRoom'],
            ]);
    }

    /**
     * 売買情報編集ページ
     * @param int $roomId
     * @return response
     */
    public function Edit($roomId)
    {
        $room = Room::find($roomId);
        $rentData = $room->getRoomSalesVer($roomId);
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
        if($request->price || $request->previous_price || $request->registered_at || $request->changed_at){
            StockSalesRoom::updateOrCreate(
                ['id' => $stockId ],
                [
                    'room_id' => $roomId,
                    'price' => $request->price,
                    'previous_price' => $request->previous_price,
                    'registered_at' => $request->registered_at,
                    'changed_at' => $request->changed_at,
                ]
                );
        }
        //売買成約更新
        if($request->sold_price || $request->sold_previous_price || $request->sold_registered_at || $request->sold_changed_at){
            SoldSalesRoom::updateOrCreate(
                ['id' => $soldId ],
                [
                    'room_id' => $roomId,
                    'price' => $request->sold_price,
                    'previous_price' => $request->sold_previous_price,
                    'registered_at' => $request->sold_registered_at,
                    'changed_at' => $request->sold_changed_at,
                ]
                );
        }
        //売買バージョンページにリダイレクト
        $buildingId = Room::where('id',$roomId)->value('building_id');
        return redirect()->route('building_sales',$buildingId);
    }

    public function destroy($stockSalesRoomId = -1,$soldSalesRoomId = -1)
    {
        $soldSalesRoom = SoldSalesRoom::find($soldSalesRoomId);
        $stockSalesRoom = StockSalesRoom::find($stockSalesRoomId);
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

    /**
     * 売買階数別検索
     * @param int $buildingId,$floor
     * @return response
     */
    public function floorSort($buildingId,$floor)
    {
        $building = Building::with(['rooms' => function($query){
            $query->where('expected_price','>',0);
        }])->select('id','building_name','total_unit')->find($buildingId);
        //全階数取得
        $floor_numbers = [];
        $rooms = new Room();
        $rooms = $rooms->getForSales($buildingId);
        foreach($rooms as $room){
            $floor_numbers[] = $room->floor_number;
        }
        $floor_numbers = array_unique($floor_numbers);

        $rooms = Room::with(['building:id,building_name','soldSalesRooms:id,room_id,price,previous_price,changed_at,registered_at','stockSalesRooms:id,room_id,price,previous_price,changed_at,registered_at','copyOfRegisters:id,room_id,pdf_filename'])
                        ->where('building_id',$buildingId)
                        ->where('floor_number',$floor)
                        ->orderBy('id','asc')
                        ->get();

        $publishedUnitPrice = $this->publishedUnitPrice($rooms);//最小新築時坪単価
        $publishedPrice     = $this->publishedPrice($rooms);// 最小新築時売買価格

        return view('sales.salesFloor',compact('rooms','building','floor_numbers','floor','publishedUnitPrice','publishedPrice'));
    }

    /**
     * 間取タイプ別検索
     * @param int $buildingId
     * @param string $layout_type
     * @return response
     */
    public function layoutTypeSort($buildingId,$layoutType)
    {
        $building = Building::with(['rooms' => function($query){
            $query->where('expected_price','>',0);
        }])->select('id','building_name','total_unit')->find($buildingId);
        $rooms = Room::with(['building:id,building_name','soldSalesRooms:id,room_id,price,previous_price,changed_at,registered_at','stockSalesRooms:id,room_id,price,previous_price,changed_at,registered_at','copyOfRegisters:id,room_id,pdf_filename'])
                        ->where('building_id',$buildingId)
                        ->where('layout_type',$layoutType)
                        ->orderBy('id','asc')
                        ->get();
        $layout_type = rtrim($layoutType);
        $publishedUnitPrice = $this->publishedUnitPrice($rooms);//最小新築時坪単価
        $publishedPrice     = $this->publishedPrice($rooms);// 最小新築時売買価格

        return view('sales.layoutType',compact('rooms','building','layout_type','publishedUnitPrice','publishedPrice'));
    }

    public function publishedUnitPrice($rooms)
    {
        $publishedUnitPrices = [];
        foreach($rooms as $room){
            if($room->occupied_area != 0){
                $publishedUnitPrices [] = round($room->published_price / ($room->occupied_area * 0.3025));
            }
        }
        if($publishedUnitPrices){
            return min($publishedUnitPrices);
        }else{
            return 0;
        }
    }

    public function publishedPrice($rooms)
    {
        $publishedPrices = [];
        foreach($rooms as $room){
            if($room->published_price != 0){
                $publishedPrices [] = $room->published_price;
            }
        }
        if($publishedPrices){
            return min($publishedPrices);
        }else{
            return 0;
        }
    }
}
