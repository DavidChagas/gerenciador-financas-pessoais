<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    public $timestamps = false;

    protected $fillable = ['valor', 'status', 'data', 'descricao', 'receita_fixa', 'observacao'];

    public function conta(){
        return $this->belongsTo(conta::class, 'conta_id');
    }
    public function categoriaReceita(){
        return $this->belongsTo(categoriaReceita::class, 'categoria_receita_id');
    }
}
