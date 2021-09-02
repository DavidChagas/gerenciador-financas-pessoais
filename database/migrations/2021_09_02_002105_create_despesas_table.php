<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDespesasTable extends Migration
{
    public function up(){
        Schema::create('despesas', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status');
            $table->date('data');
            $table->text('descricao');
            $table->boolean('despesa_fixa');
            $table->text('observacao');

            $table->integer('conta_id')->unsigned();
            $table->foreign('conta_id')->references('id')->on('contas');
            $table->integer('categoria_despesa_id')->unsigned();
            $table->foreign('categoria_despesa_id')->references('id')->on('categoria_despesas');
        });
    }

    public function down(){
        Schema::dropIfExists('despesas');
    }
}
