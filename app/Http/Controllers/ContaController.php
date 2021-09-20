<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    private $conta;

    public function __construct(){
        $this->conta = new Conta();
    }

    public function index(){
        $contas = $this->conta::all();
        return view('layouts.contas.listar')->with('infos', $contas);
    }

    public function create(){
        //
    }

    public function store(Request $request){
        $conta =  $this->conta;
        $conta->descricao = $request->input('descricao');
        $conta->usuario_id = $request->user()->id;

        $conta->save();

        return redirect('/contas')->with('success', 'conta salva com sucesso!');
    }

    public function show(Conta $conta){
        echo 'show';
    }

    public function edit(Conta $conta){
        echo 'editt';
    }

    public function update(Request $request, Conta $conta){
        //
    }

    public function destroy(Conta $conta){
        //
    }
}
