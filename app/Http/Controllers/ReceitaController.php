<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use Illuminate\Http\Request;

class ReceitaController extends Controller{

    public function __construct(){
        $this->receita = new Receita();
    }
    
    public function index(){
        $receitas = $this->receita::all();
        return view('layouts/receita/listar')->with('receitas', $receitas);
    }

    public function create(){
        //
    }

    public function store(Request $request){
        //
    }

    public function show(Receita $receita){
        //
    }

    public function edit(Receita $receita){
        //
    }

    public function update(Request $request, Receita $receita){
        //
    }

    public function destroy(Receita $receita){
        //
    }
}
