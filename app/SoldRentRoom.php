<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoldRentRoom extends Model
{
    protected $guarded = ['id'];

    public function room()
    {
        return $this->belongsTo('App\Room');
    }

    // public function updateOrCreate($soldId,$roomId,$soldRentRoomData,$request)
    // {
    //     $this::updateOrCreate(
    //         ['id' => $soldId ],
    //         [
    //             'room_id' => $roomId,
    //             'price' => $soldRentRoomData['sold_price'],
    //             'previous_price' => $soldRentRoomData['sold_previous_price'],
    //             'registered_at' => $request->sold_registered_at,
    //             'changed_at' => $request->sold_changed_at,
    //         ]
    //         );
    // } 
}
