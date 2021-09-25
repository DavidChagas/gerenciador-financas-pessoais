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
        //
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
