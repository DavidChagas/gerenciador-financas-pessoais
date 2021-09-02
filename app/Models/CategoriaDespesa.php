<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaDespesa extends Model{
    public $timestamps = false;

    protected $fillable = ['descricao'];

    public function despesas(){
        return $this->hasMany(Despesa::class);
    }
}
