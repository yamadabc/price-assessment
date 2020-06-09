<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SoldSalesRoom;
use App\StockSalesRoom;
use App\Room;

class SalesController extends Controller
{
    public function destroy($stockSalesRoomId = -1,$soldSalesRoomId = -1)
    {
        $soldSalesRoom = SoldSalesRoom::find($soldSalesRoomId);
        $stockSalesRoom = StockSalesRoom::find($stockSalesRoomId);
        if($soldSalesRoom){
            $soldSalesRoom->delete();
        }
        if($stockSalesRoom = StockSalesRoom::find($stockSalesRoomId)){
            $stockSalesRoom->delete();
        }
        
        //売買バージョンページにリダイレクト
        \Session::flash('flash_message', '売買情報を削除しました');
        return back();
    }
}
