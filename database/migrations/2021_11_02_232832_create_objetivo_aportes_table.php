<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetivoAportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('objetivo_aportes', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('valor');
            $table->date('data');

            $table->integer('objetivo_id')->unsigned();
            $table->foreign('objetivo_id')->references('id')->on('objetivos');
        });
    }

    public function down(){
        Schema::dropIfExists('objetivo_aportes');
    }
}
