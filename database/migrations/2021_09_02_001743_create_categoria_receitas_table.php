<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaReceitasTable extends Migration
{
    public function up(){
        Schema::create('categoria_receitas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
        });
    }

    public function down(){
        Schema::dropIfExists('categoria_receitas');
    }
}
