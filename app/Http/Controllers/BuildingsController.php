<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;
use App\Room;

class BuildingsController extends Controller
{
    /* 
    *全建物データ取得
    *
    */
    public function index()
    {
        $builings = Building::getWithRooms();
        return view('welcome',['buildings' => $builings]);
    }

    public function show($id)
    {
        $building = new Building();
        return view('buildings.show',['building' => $building->getForRoomsShow($id)]);
    }
    
}
