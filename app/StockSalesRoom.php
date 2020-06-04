<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockSalesRoom extends Model
{
    protected $guarded = ['id'];

    public function room()
    {
        return $this->belongsTo('App\Room');
    }

    //nullなら0を代入
    public function nullSubZero($request)
    {
        if($request->price === null){
            $price = 0;
        }else{
            $price = $request->price;
        }

        if($request->previous_price === null){
            $previous_price = 0;
        }else{
            $previous_price = $request->previous_price;
        }

        if($request->management_fee === null){
            $management_fee = 0;
        }else{
            $management_fee = $request->management_fee;
        }

        if($request->reserve_fund === null){
            $reserve_fund = 0;
        }else{
            $reserve_fund = $request->reserve_fund;
        }
        
        return ['price' => $price ,'previous_price' => $previous_price,'management_fee' => $management_fee,'reserve_fund' => $reserve_fund];
    }
}
