<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaReceita extends Model{
    public $timestamps = false;

    protected $fillable = ['descricao'];

    public function receitas(){
        return $this->hasMany(Receita::class);
    }
}
