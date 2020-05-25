<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockRentRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_rent_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('room_id')->index();
            $table->float('price',8,2);//掲載中の賃料
            $table->float('previous_price',8,2)->default(0);//変更前価格
            $table->integer('management_fee')->default(0);//管理費
            $table->integer('monthly_fee')->default(0);//共益費
            $table->float('security_deposit',10,2)->default(0);//敷金
            $table->float('gratuity_fee',10,2)->default(0);//礼金
            $table->integer('deposit')->default(0);//保証金
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
        Schema::dropIfExists('stock_rent_rooms');
    }
}
