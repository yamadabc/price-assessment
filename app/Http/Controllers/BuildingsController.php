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
        $buildings = Building::with('rooms')->select('id','building_name','total_unit')->get();
        return view('welcome',['buildings'=>$buildings]);
    }
}
