<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SplFileObject;
use App\Room;
use App\Building;
use DB;
use App\Http\Controllers\Validator;
use App\Http\Requests\CSVFormRequest;
use App\Facades\CSV;

class CSVController extends Controller
{
    protected $room = null;
    protected $building = null;

    public function __construct(Room $room,Building $building)
    {
        $this->room = $room;
        $this->building = $building;
    }
    /**
     * 
     * @param  CSV  $request
     * @return Response
     */
    public function importBuilding(CSVFormRequest $request)
    {   
        $request->validated();

        $array = CSV::importBuildingPrepare($request);
        $array_count = count($array);
        if($array_count < 500){
            Building::insert($array);
        }else{
            $array_partial = array_chunk($array,500);//配列を５００ずつに分割
            $array_partial_count = count($array_partial);
            //分割した数だけinsert
            for($i = 0;$i <= $array_partial_count-1;$i++){
                Building::insert($array_partial[$i]);
            }
        }
        $builings = Building::getWithRooms();
        \Session::flash('flash_message', '物件情報を登録しました');
        return view('welcome',['buildings' => $builings]);
    }
    /**
     * 
     * @param  CSV  $request
     * @return Response
     */
    public function importRoom(CSVFormRequest $request)
    {   
        $request->validated();

        $array = CSV::importRoomPrepare($request);
        $array_count = count($array);
        if($array_count < 500){
            Room::insert($array);
        }else{
            $array_partial = array_chunk($array,500);//配列を５００ずつに分割
            $array_partial_count = count($array_partial);
            //分割した数だけinsert
            for($i = 0;$i <= $array_partial_count-1;$i++){
                Room::insert($array_partial[$i]);
            }
        }
        $builings = Building::getWithRooms();
        \Session::flash('flash_message', '部屋情報を登録しました');
        return view('welcome',['buildings' => $builings]);
    }

    public function importBuildingUpdate(CSVFormRequest $request)
    {
        $request->validated();

        $array = CSV::importBuildingPrepare($request);
        $array_count = count($array);
        if($array_count < 500){
            foreach($array as $row){
                $building = Building::where('id',$row['id']);
                $building->update($row);
            }
        }else{
            $array_partial = array_chunk($array,500);//配列を５００ずつに分割
            $array_partial_count = count($array_partial);
            //分割した数だけinsert
            for($i = 0;$i <= $array_partial_count-1;$i++){
                foreach($array as $row){
                    $building = Building::where('id',$row['id']);
                    $building->update($row);
                }
            }
        }
        $builings = Building::getWithRooms();
        \Session::flash('flash_message', '物件情報を編集しました');
        return view('welcome',['buildings' => $builings]);
    }
}
