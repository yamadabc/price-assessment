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
            $table->char('room_number',150)->index();
            $table->smallInteger('floor_number')->index();
            $table->char('layout',50)->nullable();
            $table->char('direction',50)->nullable();
            $table->decimal('occupied_area',6,2)->default(0);
            $table->decimal('balcony_area',6,2)->default(0);
            $table->decimal('roof_balcony_area',6,2)->default(0);
            $table->decimal('terass_area',6,2)->default(0);
            $table->decimal('garden_area',6,2)->default(0);
            $table->char('residential_building_name',100)->nullable();//棟名
            $table->char('layout_type',100)->nullable()->index();
            $table->integer('published_price')->default(0);//新築時売買価格
            $table->integer('expected_price');//予想売買価格
            $table->integer('expected_rent_price');//予想賃料
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
