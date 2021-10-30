<?php

namespace App\Http\Controllers;

use App\Models\Objetivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObjetivoController extends Controller{
    private $objetivo;

    public function __construct(){
        $this->objetivo = new Objetivo();
    }

    public function index(){
        $objetivos = $this->objetivo::all()->where('usuario_id', '=', Auth::id());
        return view('layouts.objetivos.listar')->with('objetivos', $objetivos);
    }

    public function create(){
        return view('layouts/objetivos/cadastrar');
    }

    public function store(Request $request){
        $objetivo =  $this->objetivo;
        
        $objetivo->nome = $request->input('nome');
        $objetivo->descricao = $request->input('descricao');
        $objetivo->valor = $request->input('valor');
        $objetivo->data_inicial = $request->input('data_inicial');
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
        $objetivo->nome = $request->input('nome');
        $objetivo->descricao = $request->input('descricao');
        $objetivo->valor = $request->input('valor');
        $objetivo->data_inicial = $request->input('data_inicial');
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