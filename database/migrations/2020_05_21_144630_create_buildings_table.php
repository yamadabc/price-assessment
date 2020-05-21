<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('building_name',150)->index();
            $table->char('prefecture',20);
            $table->char('city',80);
            $table->char('street',150);
            $table->smallInteger('built_year');
            $table->smallInteger('built_month')->default(0);
            $table->smallInteger('total_unit')->nullable();
            $table->char('layout',80)->nullable();
            $table->char('occupied_area',80)->nullable();//占有面積
            $table->char('construction',80);//構造
            $table->char('construction_company',80)->nullable();//施工会社
            $table->char('seller',80)->nullable();//分譲時会社
            $table->char('parking',80)->nullable();
            $table->char('kindergarten_district',80)->nullable();
            $table->char('primary_school_district',80)->nullable();
            $table->char('middle_school_district',80)->nullable();
            $table->char('station_route_01',80)->nullable();//最寄り駅路線1
            $table->char('station_name_01',80);
            $table->smallInteger('station_walk_01');
            $table->char('station_route_02',80)->nullable();//最寄り駅路線2
            $table->char('station_name_02',80)->nullable();
            $table->smallInteger('station_walk_02')->nullable();
            $table->char('station_route_03',80)->nullable();//最寄り駅路線3
            $table->char('station_name_03',80)->nullable();
            $table->smallInteger('station_walk_03')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buildings');
    }
}
