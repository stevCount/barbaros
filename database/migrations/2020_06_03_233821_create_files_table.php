<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('entity_id');
            $table->string('prefix');
            $table->string('name');
            $table->string('entity_name');
            $table->string('location_url');
            $table->string('type');
            $table->string('extention');
            $table->string('size');
            $table->string('title');
            $table->string('description');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('files');
    }
}
