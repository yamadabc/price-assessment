<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockRentRoom extends Model
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

        if($request->monthly_fee === null){
            $monthly_fee = 0;
        }else{
            $monthly_fee =$request->monthly_fee;
        }

        if($request->security_deposit === null){
            $security_deposit = 0;
        }else{
            $security_deposit = $request->price * $request->security_deposit;
        }

        if($request->gratuity_fee === null){
            $gratuity_fee = 0;
        }else{
            $gratuity_fee =  $request->price * $request->gratuity_fee;
        }

        if($request->deposit === null){
            $deposit = 0;
        }else{
            $deposit = $request->deposit;
        }

        if($request->sold_price === null){
            $sold_price = 0;
        }else{
            $sold_price = $request->sold_price;
        }

        if($request->sold_previous_price === null){
            $sold_previous_price = 0;
        }else{
            $sold_previous_price = $request->sold_previous_price;
        }

        return [
            'price'   => $price,
            'previous_price'   => $previous_price,
            'management_fee'   => $management_fee,
            'monthly_fee'      => $monthly_fee,
            'security_deposit' => $security_deposit,
            'gratuity_fee'     => $gratuity_fee,
            'deposit'          => $deposit,
            'sold_price'   => $sold_price,
            'sold_previous_price'   => $sold_previous_price,
        ];
    }

    
}
