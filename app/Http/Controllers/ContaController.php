<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContaController extends Controller{
    
    private $conta;

    public function __construct(){
        $this->conta = new Conta();
    }

    public function index(){
        $contas = DB::table('contas')->select('*')->where('usuario_id', '=', Auth::id())->get();
        
        return view('layouts.contas.listar')->with('infos', $contas);
    }

    public function create(){
        return view('layouts/contas/cadastrar');
    }

    public function store(Request $request){
        $request_valor_formatado = (int) preg_replace('/\D/', '', $request->input('valor'));

        $conta =  $this->conta;
        $conta->descricao = $request->input('descricao');
        $conta->valor = $request_valor_formatado;
        $conta->usuario_id = $request->user()->id;

        $conta->save();

        return redirect('/contas')->with('success', 'Conta salva com sucesso!');
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
            $conta->receitas->each( function($receita){
                $receita->delete();
            });
            $conta->despesas->each( function($despesa){
                $despesa->delete();
            });
            $conta->delete();
            return redirect('/contas')->with('success', 'Conta excluida com sucesso!');
        } catch (\Illuminate\Database\QueryException $qe) {
            return ['status' => 'errorQuery', 'message' => $qe->getMessage()];
        } catch (\PDOException $e) {
            return ['status' => 'errorPDO', 'message' => $e->getMessage()];
        }
    }
}
