<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    public $timestamps = false;

    protected $fillable = ['valor', 'status', 'data', 'descricao', 'despesa_fixa', 'observacao'];

    public function conta(){
        return $this->belongsTo(conta::class, 'conta_id');
    }
    public function categoriaDespesa(){
        return $this->belongsTo(categoriaDespesa::class, 'categoria_despesa_id');
    }
}
