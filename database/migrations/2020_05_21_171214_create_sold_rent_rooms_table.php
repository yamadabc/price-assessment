<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldRentRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_rent_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('room_id')->index();
            $table->decimal('price',8,2);//成約賃料（万円）
            $table->decimal('previous_price',8,2)->default(0);//成約前賃料（万円）
            $table->integer('management_fee')->default(0);//管理費
            $table->integer('monthly_fee')->default(0);//共益費
            $table->integer('security_deposit')->default(0);//敷金
            $table->integer('gratuity_fee')->default(0);//礼金
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
        Schema::dropIfExists('sold_rent_rooms');
    }
}
