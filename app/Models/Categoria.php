<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model{
    public $timestamps = false;

    protected $fillable = ['descricao', 'tipo'];

    public function usuario(){
        return $this->belongsTo(usuario::class, 'usuario_id');
    }
    public function receitas(){
        return $this->hasMany(Receita::class);
    }
    public function despesas(){
        return $this->hasMany(Despesa::class);
    }
}
