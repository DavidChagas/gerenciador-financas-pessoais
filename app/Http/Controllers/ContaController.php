<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContaController extends Controller{
    
    private $conta;

    public function __construct(){
        $this->conta = new Conta();
    }

    public function index(){
        $contas = $this->conta::all()->where('usuario_id', '=', Auth::id());
        return view('layouts.contas.listar')->with('infos', $contas);
    }

    public function create(){
        return view('layouts/contas/cadastrar');
    }

    public function store(Request $request){
        $conta =  $this->conta;
        $conta->descricao = $request->input('descricao');
        $conta->valor = $request->input('valor');
        $conta->usuario_id = $request->user()->id;

        $conta->save();

        return redirect('/contas')->with('success', 'conta salva com sucesso!');
    }

    public function show(Conta $conta){
        dd($conta);
    }

    public function edit(Conta $conta){
        return view('layouts.contas.cadastrar')->with('conta', $conta);
    }

    public function update(Request $request, Conta $conta){
        $conta->descricao = $request->input('descricao');
       
        $conta->save();

        return redirect('/contas')->with('success', 'Conta alterada com sucesso!');
    }

    public function destroy(Conta $conta){
        try {
            $conta->delete();
            return redirect('/contas')->with('success', 'Conta excluida com sucesso!');
        } catch (\Illuminate\Database\QueryException $qe) {
            return ['status' => 'errorQuery', 'message' => $qe->getMessage()];
        } catch (\PDOException $e) {
            return ['status' => 'errorPDO', 'message' => $e->getMessage()];
        }
    }
}
