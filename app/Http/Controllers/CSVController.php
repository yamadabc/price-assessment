<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SplFileObject;
use App\Room;
use App\Http\Controllers\Validator;

class CSVController extends Controller
{
    protected $room = null;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }
    /**
     * 
     * @param  CSV  $request
     * @return Response
     */
    public function import(Request $request)
    {   
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt|mimetypes:text/plain|max:1024',
        ]);

        setlocale(LC_ALL, 'ja_JP.UTF-8');//日本語に設定
        $uploaded_file = $request->file('csv');
        $file_path = $request->file('csv')->path($uploaded_file);//絶対パス取得
        $data = file_get_contents($file_path);
        $data = mb_convert_encoding($data, 'UTF-8', 'SJIS-win');
        $temp = tmpfile();
        $meta = stream_get_meta_data($temp);
        fwrite($temp, $data);
        rewind($temp);
        $file = new SplFileObject($meta['uri'], 'rb');

        $uploaded_file = $request->file('csv');
        $file_path = $request->file('csv')->path($uploaded_file);//絶対パス取得

        $file = new SplFileObject($file_path);
        $file->setFlags(SplFileObject::READ_CSV);//csv列として行を読み込む
        $row_count = 1;
        $array = [];
//取得したオブジェクト読み込み
        foreach($file as $row)
        {
            if($row === [null])continue;//最終行が空だったらそれ以降の処理を行わない

            if($row_count > 1)//ヘッダーは取り込まない
            {
                 // CSVの文字コードがSJISなのでUTF-8に変更
                 $building_name   = $row[1];
                 $building_id     = $row[2];
                 $room_number     = $row[3];
                 $floor_number    = $row[4];
                 $layout          = $row[5];
                 $direction       = $row[6];
                 $occupied_area   = $row[7];
                 $balcony_area    = $row[8];
                 $layout_type     = $row[9];
                 $published_price = $row[10];
                 $created_at      = $row[11];
                 $updated_at      = $row[12];

                 $csvimport_array = [
                     'building_name'   => $building_name,
                     'building_id'     => $building_id,
                     'room_number'     => $room_number,
                     'floor_number'    => $floor_number,
                     'layout'          => $layout,
                     'direction'       => $direction,
                     'occupied_area'   => $occupied_area,
                     'balcony_area'    => $balcony_area,
                     'layout_type'     => $layout_type,
                     'published_price' => $published_price,
                     'created_at'      => $created_at,
                     'updated_at'      => $updated_at,
                 ];
                 array_push($array, $csvimport_array);
            }
            $row_count++;
        }
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

        return view('welcome');
    }
}
