<?php
namespace App\Http\Components;

use SplFileObject;

class CSV
{
    public function importBuildingPrepare($request)
    {
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
                 $building_name           = $row[1];
                 $prefecture              = $row[2];
                 $city                    = $row[3];
                 $street                  = $row[4];
                 $built_year              = $row[5];
                 $built_month             = $row[6];
                 $total_unit              = $row[7];
                 $layout                  = $row[8];
                 $occupied_area           = $row[9];
                 $construction            = $row[10];
                 $construction_company    = $row[11];
                 $seller                  = $row[12];
                 $parking                 = $row[13];
                 $level_underground       = $row[14];
                 $level_floor             = $row[15];
                 $kindergarten_district   = $row[16];
                 $primary_school_district = $row[17];
                 $middle_school_district  = $row[18];
                 $station_route_01        = $row[19];
                 $station_name_01         = $row[20];
                 $station_walk_01         = $row[21];
                 $station_route_02        = $row[22];
                 $station_name_02         = $row[23];
                 $station_walk_02         = $row[24];
                 $station_route_03        = $row[25];
                 $station_name_03         = $row[26];
                 $station_walk_03         = $row[27];
            
                 
                 $csvimport_array = [
                     'building_name'           => $building_name,
                     'prefecture'              => $prefecture,
                     'city'                    => $city,
                     'street'                  => $street,
                     'built_year'              => $built_year,
                     'built_month'             => $built_month,
                     'total_unit'              => $total_unit,
                     'layout'                  => $layout,
                     'occupied_area'           => $occupied_area,
                     'construction'            => $construction,
                     'construction_company'    => $construction_company,
                     'seller'                  => $seller,
                     'parking'                 => $parking,
                     'level_underground'       => $level_underground,
                     'level_floor'             => $level_floor,
                     'kindergarten_district'   => $kindergarten_district,
                     'primary_school_district' => $primary_school_district,
                     'middle_school_district'  => $middle_school_district,
                     'station_route_01'        => $station_route_01,
                     'station_name_01'         => $station_name_01,
                     'station_walk_01'         => $station_walk_01,
                     'station_route_02'        => $station_route_02,
                     'station_name_02'         => $station_name_02,
                     'station_walk_02'         => $station_walk_02,
                     'station_route_03'        => $station_route_03,
                     'station_name_03'         => $station_name_03,
                     'station_walk_03'         => $station_walk_03,
                 ];
                 array_push($array, $csvimport_array);
            }
            $row_count++;
        }
        return $array;
    }
    public function updateBuildingPrepare($request)
    {
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
                 $id                      = $row[0];
                 $building_name           = $row[1];
                 $prefecture              = $row[2];
                 $city                    = $row[3];
                 $street                  = $row[4];
                 $built_year              = $row[5];
                 $built_month             = $row[6];
                 $total_unit              = $row[7];
                 $layout                  = $row[8];
                 $occupied_area           = $row[9];
                 $construction            = $row[10];
                 $construction_company    = $row[11];
                 $seller                  = $row[12];
                 $parking                 = $row[13];
                 $level_underground       = $row[14];
                 $level_floor             = $row[15];
                 $kindergarten_district   = $row[16];
                 $primary_school_district = $row[17];
                 $middle_school_district  = $row[18];
                 $station_route_01        = $row[19];
                 $station_name_01         = $row[20];
                 $station_walk_01         = $row[21];
                 $station_route_02        = $row[22];
                 $station_name_02         = $row[23];
                 $station_walk_02         = $row[24];
                 $station_route_03        = $row[25];
                 $station_name_03         = $row[26];
                 $station_walk_03         = $row[27];
            
                 
                 $csvimport_array = [
                     'id'                      => $id,
                     'building_name'           => $building_name,
                     'prefecture'              => $prefecture,
                     'city'                    => $city,
                     'street'                  => $street,
                     'built_year'              => $built_year,
                     'built_month'             => $built_month,
                     'total_unit'              => $total_unit,
                     'layout'                  => $layout,
                     'occupied_area'           => $occupied_area,
                     'construction'            => $construction,
                     'construction_company'    => $construction_company,
                     'seller'                  => $seller,
                     'parking'                 => $parking,
                     'level_underground'       => $level_underground,
                     'level_floor'             => $level_floor,
                     'kindergarten_district'   => $kindergarten_district,
                     'primary_school_district' => $primary_school_district,
                     'middle_school_district'  => $middle_school_district,
                     'station_route_01'        => $station_route_01,
                     'station_name_01'         => $station_name_01,
                     'station_walk_01'         => $station_walk_01,
                     'station_route_02'        => $station_route_02,
                     'station_name_02'         => $station_name_02,
                     'station_walk_02'         => $station_walk_02,
                     'station_route_03'        => $station_route_03,
                     'station_name_03'         => $station_name_03,
                     'station_walk_03'         => $station_walk_03,
                 ];
                 array_push($array, $csvimport_array);
            }
            $row_count++;
        }
        return $array;
    }

    public function importRoomPrepare($request)
    {
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
                 $building_id               = $row[1];
                 $room_number               = $row[2];
                 $floor_number              = $row[3];
                 $layout                    = $row[4];
                 $direction                 = $row[5];
                 $occupied_area             = $row[6];
                 $balcony_area              = $row[7];
                 $roof_balcony_area         = $row[8];
                 $terass_area               = $row[9];
                 $garden_area               = $row[10];
                 $residential_building_name = $row[11];
                 $layout_type               = $row[12];
                 $published_price           = $row[13];
                 $expected_price            = $row[14];
                 $expected_rent_price       = $row[15];

                 $csvimport_array = [
                     'building_id'               => $building_id,
                     'room_number'               => $room_number,
                     'floor_number'              => $floor_number,
                     'layout'                    => $layout,
                     'direction'                 => $direction,
                     'occupied_area'             => $occupied_area,
                     'balcony_area'              => $balcony_area,
                     'roof_balcony_area'         => $roof_balcony_area,
                     'terass_area'               => $terass_area,
                     'garden_area'               => $garden_area,
                     'residential_building_name' => $residential_building_name,
                     'layout_type'               => $layout_type,
                     'published_price'           => $published_price,
                     'expected_price'            => $expected_price,
                     'expected_rent_price'       => $expected_rent_price,
                 ];
                 array_push($array, $csvimport_array);
            }
            $row_count++;
        }
        return $array;
    }
    public function updateRoomPrepare($request)
    {
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
                 $id                        = $row[0];
                 $building_id               = $row[1];
                 $room_number               = $row[2];
                 $floor_number              = $row[3];
                 $layout                    = $row[4];
                 $direction                 = $row[5];
                 $occupied_area             = $row[6];
                 $balcony_area              = $row[7];
                 $roof_balcony_area         = $row[8];
                 $terass_area               = $row[9];
                 $garden_area               = $row[10];
                 $residential_building_name = $row[11];
                 $layout_type               = $row[12];
                 $published_price           = $row[13];
                 $expected_price            = $row[14];
                 $expected_rent_price       = $row[15];

                 $csvimport_array = [
                     'id'                        => $id,
                     'building_id'               => $building_id,
                     'room_number'               => $room_number,
                     'floor_number'              => $floor_number,
                     'layout'                    => $layout,
                     'direction'                 => $direction,
                     'occupied_area'             => $occupied_area,
                     'balcony_area'              => $balcony_area,
                     'roof_balcony_area'         => $roof_balcony_area,
                     'terass_area'               => $terass_area,
                     'garden_area'               => $garden_area,
                     'residential_building_name' => $residential_building_name,
                     'layout_type'               => $layout_type,
                     'published_price'           => $published_price,
                     'expected_price'            => $expected_price,
                     'expected_rent_price'       => $expected_rent_price,
                 ];
                 array_push($array, $csvimport_array);
            }
            $row_count++;
        }
        return $array;
    }
}