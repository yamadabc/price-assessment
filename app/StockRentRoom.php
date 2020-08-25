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

    /**
     * nullなら0を代入
     * @param Request $request
     * @return int[]
     */
    public function nullSubZero($request)
    {
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
            $monthly_fee = $request->monthly_fee;
        }

        if($request->security_deposit === null){
            $security_deposit = 0;
        }else{
            $security_deposit = $request->security_deposit;
        }

        if($request->gratuity_fee === null){
            $gratuity_fee = 0;
        }else{
            $gratuity_fee = $request->gratuity_fee;
        }

        if($request->deposit === null){
            $deposit = 0;
        }else{
            $deposit = $request->deposit;
        }

        return ['previous_price' => $previous_price ,'management_fee' => $management_fee,'monthly_fee' => $monthly_fee,'security_deposit' => $security_deposit ,'gratuity_fee' => $gratuity_fee,'deposit' => $deposit];
    }
}
