<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model{

    public $timestamps = false;

    protected $fillable = ['descricao'];

    public function usuario(){
        return $this->belongsTo(usuario::class);
    }
}
