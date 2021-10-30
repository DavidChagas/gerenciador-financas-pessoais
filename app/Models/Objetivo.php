<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model{
    public $timestamps = false;

    protected $fillable = ['nome', 'descricao', 'valor', 'data_inicial', 'data_final'];
    
    public function usuario(){
        return $this->belongsTo(usuario::class);
    }
}
