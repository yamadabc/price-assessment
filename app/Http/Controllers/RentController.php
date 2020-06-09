<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SoldRentRoom;
use App\StockRentRoom;

class RentController extends Controller
{
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
