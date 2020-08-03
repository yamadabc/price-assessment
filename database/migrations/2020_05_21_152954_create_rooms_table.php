<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('building_id')->index();
            $table->char('room_number',150)->nullable()->index();
            $table->smallInteger('floor_number')->nullable()->index();
            $table->char('layout',50)->nullable();
            $table->char('direction',50)->nullable();
            $table->float('occupied_area',6,2)->nullable();
            $table->float('balcony_area',6,2)->default(0);
            $table->float('roof_balcony_area',6,2)->default(0);
            $table->float('terass_area',6,2)->default(0);
            $table->float('garden_area',6,2)->default(0);
            $table->char('residential_building_name',100)->nullable();//棟名
            $table->char('layout_type',100)->nullable()->index();
            $table->float('published_price',8,2)->nullable();//新築時売買価格
            $table->float('expected_price',8,2)->nullable();//予想売買価格
            $table->float('expected_rent_price',10,2)->nullable();//予想賃料
            $table->boolean('has_no_data')->default(0);
            $table->timestamps();

            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
