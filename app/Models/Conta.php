<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model{

    public $timestamps = false;

    protected $fillable = ['descricao', 'valor'];

    public function usuario(){
        return $this->belongsTo(usuario::class);
    }
    public function receitas(){
    	//relação de uma conta (this) para muitas receitas (Receita::class)
    	return $this->hasMany(Receita::class);
    }
    public function despesas(){
    	//relação de uma conta (this) para muitas despesas (Despesa::class)
    	return $this->hasMany(Despesa::class);
    }
}
