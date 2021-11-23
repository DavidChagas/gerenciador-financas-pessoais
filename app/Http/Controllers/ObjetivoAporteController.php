<?php

namespace App\Http\Controllers;

use App\Models\ObjetivoAporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ObjetivoAporteController extends Controller{
    private $objetivoAporte;

    public function __construct(){
        $this->objetivoAporte = new ObjetivoAporte();
    }

    public function index(){
       
    }

    public function create(){
      
    }

    public function store(Request $request){
        $request_valor_formatado = (int) preg_replace('/\D/', '', $request->input('valor'));
        
        $objetivoAporte =  $this->objetivoAporte;
        
        $objetivoAporte->valor = $request_valor_formatado;
        $objetivoAporte->data = $request->input('data');
        $objetivoAporte->objetivo_id = $request->input('objetivo_id');

        $objetivoAporte->save();

        return redirect('/objetivos')->with('success', 'Aporte salvo com sucesso!');
    }

    public function aportes(){
        $id_objetivo = $_GET['idObjetivo'];

        $objetivoAportes = DB::table('objetivos')
        ->join('objetivo_aportes', 'objetivos.id', '=', 'objetivo_aportes.objetivo_id')
        ->select('objetivo_aportes.*')
        ->where('objetivos.usuario_id', '=', Auth::id())
        ->where('objetivo_id', '=', $id_objetivo)
        ->get();
        
        return $objetivoAportes;
    }

    public function show(ObjetivoAporte $objetivoAporte){
      
    }

    public function edit(ObjetivoAporte $objetivoAporte){

    }

    public function update(Request $request, ObjetivoAporte $objetivoAporte){
        echo $objetivoAporte;
        echo $request;

    }

    public function destroy(ObjetivoAporte $objetivoAporte){
        echo $objetivoAporte;
        try {
            $objetivoAporte->delete();
            return redirect('/objetivos')->with('success', 'Aporte excluido com sucesso!');
        } catch (\Illuminate\Database\QueryException $qe) {
            return ['status' => 'errorQuery', 'message' => $qe->getMessage()];
        } catch (\PDOException $e) {
            return ['status' => 'errorPDO', 'message' => $e->getMessage()];
        }
    }
}
