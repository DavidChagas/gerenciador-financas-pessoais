<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use App\Models\Conta;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ReceitaController extends Controller{

    private $receita;
    private $conta;
    private $categoria;

    public function __construct(){
        $this->receita = new Receita();
        $this->conta = new Conta();
        $this->categoria = new Categoria();
    }
    
    public function index(){
        $receitas = $this->receita::all();
        return view('layouts.receitas.listar')->with('infos', $receitas);
    }

    public function create(){
        $contas = $this->conta::all();
        $categoriasReceita = $this->categoria::all()->where('tipo', 'Receita');
        return view('layouts/receitas/cadastrar')->with('contas', $contas)->with('categoriasReceita', $categoriasReceita);
    }

    public function store(Request $request){
        $receita =  $this->receita;
        $receita->descricao = $request->input('descricao');
        $receita->status = $request->input('status');
        $receita->data = $request->input('data');
        $receita->receita_fixa = $request->input('fixa');
        $receita->observacao = $request->input('observacao');
        $receita->conta_id = $request->input('conta');
        $receita->categoria_id = $request->input('categoria');
        // $receita->usuario_id = $request->user()->id;

        $receita->save();

        return redirect('/receitas')->with('success', 'receita salva com sucesso!');
    }

    public function show(Receita $receita){
        //
    }

    public function edit(Receita $receita){
        return view('layouts.receitas.cadastrar')->with('receita', $receita);
    }

    public function update(Request $request, Receita $receita){
        //
    }

    public function destroy(Receita $receita){
        //
    }
}
