<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockSalesRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_sales_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('room_id')->index();
            $table->integer('price');//掲載中の価格
            $table->integer('previous_price')->default(0);//変更前価格
            $table->integer('management_fee')->default(0);//管理費
            $table->integer('reserve_fund')->default(0);//修繕積立金
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
        Schema::dropIfExists('stock_sales_rooms');
    }
}
