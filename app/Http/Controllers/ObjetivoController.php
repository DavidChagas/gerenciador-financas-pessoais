<?php

namespace App\Http\Controllers;

use App\Models\Objetivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ObjetivoController extends Controller{
    private $objetivo;

    public function __construct(){
        $this->objetivo = new Objetivo();
    }

    public function index(){
        $objetivos = DB::table('objetivos')
            ->leftJoin('objetivo_aportes', 'objetivos.id', '=', 'objetivo_aportes.objetivo_id')
            ->select('objetivos.id', 'objetivos.nome', 'objetivos.descricao', 'objetivos.valor', 'objetivos.data_inicial', 'objetivos.data_final', DB::raw('sum(objetivo_aportes.valor) as total_aportado'))
            ->groupBy('objetivos.id', 'objetivos.nome', 'objetivos.descricao', 'objetivos.valor', 'objetivos.data_inicial', 'objetivos.data_final')
            ->where('objetivos.usuario_id', '=', Auth::id())
            ->get();

        return view('layouts.objetivos.listar')->with('objetivos', $objetivos);
    }

    public function create(){
        return view('layouts/objetivos/cadastrar');
    }

    public function store(Request $request){
        $request_valor_formatado = (int) preg_replace('/\D/', '', $request->input('valor'));

        $objetivo =  $this->objetivo;
        
        $objetivo->nome = $request->input('nome');
        $objetivo->descricao = $request->input('descricao');
        $objetivo->valor = $request_valor_formatado;
        $objetivo->data_inicial = date("Y-m-d");
        $objetivo->data_final = $request->input('data_final');
        $objetivo->usuario_id = $request->user()->id;

        $objetivo->save();

        return redirect('/objetivos')->with('success', 'objetivo salva com sucesso!');
    }

    public function show(Objetivo $objetivo){
        
    }

    public function edit(Objetivo $objetivo){
        return view('layouts.objetivos.cadastrar')->with('objetivo', $objetivo);
    }

    public function update(Request $request, Objetivo $objetivo){
        $request_valor_formatado = (int) preg_replace('/\D/', '', $request->input('valor'));
        
        $objetivo->nome = $request->input('nome');
        $objetivo->descricao = $request->input('descricao');
        $objetivo->valor = $request_valor_formatado;
        $objetivo->data_final = $request->input('data_final');
       
        $objetivo->save();

        return redirect('/objetivos')->with('success', 'objetivo alterado com sucesso!');
    }

    public function destroy(Objetivo $objetivo){
        try {
            $objetivo->delete();
            return redirect('/objetivos')->with('success', 'objetivo excluido com sucesso!');
        } catch (\Illuminate\Database\QueryException $qe) {
            return ['status' => 'errorQuery', 'message' => $qe->getMessage()];
        } catch (\PDOException $e) {
            return ['status' => 'errorPDO', 'message' => $e->getMessage()];
        }
    }
}
