<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Conta;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DespesaController extends Controller
{
    private $despesa;
    private $conta;
    private $categoria;

    public function __construct(){
        $this->despesa = new Despesa();
        $this->conta = new Conta();
        $this->categoria = new Categoria();
    }
    
    public function index(){
        $despesas = $this->despesa::all()->where('usuario_id', '=', Auth::id());
        return view('layouts.despesas.listar')->with('infos', $despesas);
    }

    public function create(){
        $contas = $this->conta::all()->where('usuario_id', '=', Auth::id());
        $categoriasDespesa = $this->categoria::all()->where('tipo', 'Despesa')->where('usuario_id', '=', Auth::id());
        return view('layouts/despesas/cadastrar')->with('contas', $contas)->with('categoriasDespesa', $categoriasDespesa);
    }

    public function store(Request $request){
        $despesa =  $this->despesa;
        $despesa->valor = $request->input('valor');
        $despesa->descricao = $request->input('descricao');
        $despesa->status = $request->input('status');
        $despesa->data = $request->input('data');
        $despesa->despesa_fixa = $request->input('fixa');
        $despesa->observacao = $request->input('observacao');
        $despesa->conta_id = $request->input('conta');
        $despesa->categoria_id = $request->input('categoria');
        $despesa->usuario_id = $request->user()->id;

        $despesa->save();

        return redirect('/despesas')->with('success', 'despesa salva com sucesso!');
    }

    public function show(Despesa $despesa){
        //
    }

    public function edit(Despesa $despesa){
        $contas = $this->conta::all()->where('usuario_id', '=', Auth::id());
        $categoriasDespesa = $this->categoria::all()->where('tipo', 'Despesa')->where('usuario_id', '=', Auth::id());
        
        return view('layouts.despesas.cadastrar')->with('despesa', $despesa)->with('contas', $contas)->with('categoriasDespesa', $categoriasDespesa);
    }

    public function update(Request $request, Despesa $despesa){
        $despesa->valor = $request->input('valor');
        $despesa->descricao = $request->input('descricao');
        $despesa->status = $request->input('status');
        $despesa->data = $request->input('data');
        $despesa->despesa_fixa = $request->input('fixa');
        $despesa->observacao = $request->input('observacao');
        $despesa->conta_id = $request->input('conta');
        $despesa->categoria_id = $request->input('categoria');
       
        $despesa->save();

        return redirect('/despesas')->with('success', 'Despesa alterada com sucesso!');
    }

    public function destroy(Despesa $despesa){
        try {
            $despesa->delete();
            return redirect('/despesas')->with('success', 'despesa excluida com sucesso!');
        } catch (\Illuminate\Database\QueryException $qe) {
            return ['status' => 'errorQuery', 'message' => $qe->getMessage()];
        } catch (\PDOException $e) {
            return ['status' => 'errorPDO', 'message' => $e->getMessage()];
        }
    }
}
