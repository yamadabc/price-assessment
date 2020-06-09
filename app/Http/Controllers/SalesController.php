<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SoldSalesRoom;
use App\StockSalesRoom;

class SalesController extends Controller
{
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
}
