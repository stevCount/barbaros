<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reservation_type');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('reservation_date');
            $table->string('name');
            $table->string('mobile');
            $table->string('mail')->nullable();
            $table->foreign('reservation_types')->references('id')
                ->on('reservation_type');
            $table->foreign('users')->references('id')
                ->on('user_id');
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
        Schema::dropIfExists('reservations');
    }
}
