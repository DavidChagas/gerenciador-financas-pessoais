<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDespesasTable extends Migration
{
    public function up(){
        Schema::create('despesas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('valor');
            $table->text('status');
            $table->date('data');
            $table->text('descricao');
            $table->text('despesa_fixa');
            $table->text('observacao')->nullable();;

            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->integer('conta_id')->unsigned();
            $table->foreign('conta_id')->references('id')->on('contas');
            $table->integer('categoria_id')->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categorias');
        });
    }

    public function down(){
        Schema::dropIfExists('despesas');
    }
}
