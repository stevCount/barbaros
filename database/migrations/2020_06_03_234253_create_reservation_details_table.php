<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reservation_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('hair_cut_id');
            $table->unsignedBigInteger('state_id');
            $table->integer('amount');
            $table->foreign('reservations')->references('id')
                ->on('reservation_id');
            $table->foreign('products')->references('id')
                ->on('product_id');
            $table->foreign('hair_cuts')->references('id')
                ->on('hair_cut_id');
            $table->foreign('states')->references('id')
                ->on('state_id');
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
        Schema::dropIfExists('reservation_details');
    }
}
