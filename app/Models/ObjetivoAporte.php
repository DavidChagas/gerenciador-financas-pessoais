<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjetivoAporte extends Model{
    public $timestamps = false;

    protected $fillable = ['valor', 'data'];
    
    public function objetivo(){
        return $this->belongsTo(objetivo::class);
    }
}
