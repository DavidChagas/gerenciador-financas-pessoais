<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceitasTable extends Migration
{
    public function up(){
        Schema::create('receitas', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status');
            $table->date('data');
            $table->text('descricao');
            $table->boolean('receita_fixa');
            $table->text('observacao');

            $table->integer('conta_id')->unsigned();
            $table->foreign('conta_id')->references('id')->on('contas');
            $table->integer('categoria_receita_id')->unsigned();
            $table->foreign('categoria_receita_id')->references('id')->on('categoria_receitas');
        });
    }

    public function down(){
        Schema::dropIfExists('receitas');
    }
}
