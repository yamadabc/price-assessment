<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1101;$i <= 1110;$i++){
            App\Room::create([
                    'building_id' => 1,
                    'room_number' => $i,
                    'floor_number' => 11,
                    'direction' => '南東',
                    'occupied_area' => 75.79,
                    'published_price' => 4110,
                    'expected_price' => 6614,
                    'expected_rent_price' => 262502,
                    ]);
        }
    }
}
