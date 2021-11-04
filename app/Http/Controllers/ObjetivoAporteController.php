<?php

namespace App\Http\Controllers;

use App\Models\ObjetivoAporte;
use Illuminate\Http\Request;

class ObjetivoAporteController extends Controller{
    private $objetivo_aporte;

    public function __construct(){
        $this->objetivo_aporte = new ObjetivoAporte();
    }

    public function index(){
       
    }

    public function create(){
      
    }

    public function store(Request $request){
        echo 'chegouu';
        $objetivo_aporte =  $this->objetivo_aporte;
        
        $objetivo_aporte->valor = $request->input('valor');
        $objetivo_aporte->data = $request->input('data');
        $objetivo_aporte->objetivo_id = $request->input('objetivo_id');

        $objetivo_aporte->save();

        return redirect('/objetivos')->with('success', 'objetivo_aporte salva com sucesso!');
    }

    public function show(ObjetivoAporte $objetivoAporte){
      
    }

    public function edit(ObjetivoAporte $objetivoAporte){

    }

    public function update(Request $request, ObjetivoAporte $objetivoAporte){

    }

    public function destroy(ObjetivoAporte $objetivoAporte){

    }
}
