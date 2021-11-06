<?php

namespace App\Http\Controllers;

use App\Models\ObjetivoAporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $objetivo_aporte =  $this->objetivo_aporte;
        
        $objetivo_aporte->valor = $request->input('valor');
        $objetivo_aporte->data = $request->input('data');
        $objetivo_aporte->objetivo_id = $request->input('objetivo_id');

        $objetivo_aporte->save();

        return redirect('/objetivos')->with('success', 'objetivo_aporte salva com sucesso!');
    }

    public function aportes(){
        $id_objetivo = $_GET['idObjetivo'];

        $objetivo_aportes = DB::table('objetivos')
        ->join('objetivo_aportes', 'objetivos.id', '=', 'objetivo_aportes.objetivo_id')
        ->select('objetivo_aportes.*')
        ->where('objetivos.usuario_id', '=', Auth::id())
        ->get();
        
        return $objetivo_aportes;
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
