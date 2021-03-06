<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    public $timestamps = false;

    protected $fillable = ['valor', 'status', 'data', 'descricao', 'observacao'];

    public function usuario(){
        return $this->belongsTo(usuario::class);
    }
    public function conta(){
        return $this->belongsTo(conta::class, 'conta_id');
    }
    public function categoria(){
        return $this->belongsTo(categoria::class, 'categoria_id');
    }
}
