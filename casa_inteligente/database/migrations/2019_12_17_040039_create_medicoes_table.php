<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('valor');
            $table->dateTime('data_horario');
            $table->unsignedBigInteger('sensor_id');
            $table->timestamps();

            $table->foreign('sensor_id')->references('id')->on('sensors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicoes');
    }
}
