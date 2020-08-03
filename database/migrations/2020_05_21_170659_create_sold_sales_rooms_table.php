<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldSalesRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_sales_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('room_id')->index();
            $table->float('price',8,2)->nullable();//成約価格（万円）
            $table->float('previous_price',8,2)->nullable();//成約前価格（万円）
            $table->float('management_fee',8,2)->default(0);//管理費
            $table->float('reserve_fund',8,2)->default(0);//修繕積立金
            $table->char('company_name',100)->nullable();//会員名
            $table->char('contact_phonenumber',100)->nullable();//代表電話番号
            $table->char('pic',100)->nullable();//問合せ担当者
            $table->char('email',100)->nullable();
            $table->date('registered_at')->nullable();//登録年月日
            $table->date('changed_at')->nullable();//変更年月日
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sold_sales_rooms');
    }
}
