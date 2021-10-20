<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use App\Models\Conta;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // $receitas = $this->receita::all()->where('usuario_id', '=', Auth::id());
        $receitas = DB::table('receitas')
        ->select('receitas.*', 'contas.descricao as conta', 'categorias.descricao as categoria')
        ->join('contas', function ($join) {
            $join->on('contas.id', '=', 'receitas.conta_id');
        })
        ->join('categorias', function ($join) {
            $join->on('categorias.id', '=', 'receitas.categoria_id');
        })
        ->get();
        return view('layouts.receitas.listar')->with('infos', $receitas);
    }

    public function create(){
        $contas = $this->conta::all()->where('usuario_id', '=', Auth::id());
        $categoriasReceita = $this->categoria::all()->where('tipo', 'Receita')->where('usuario_id', '=', Auth::id());
        return view('layouts/receitas/cadastrar')->with('contas', $contas)->with('categoriasReceita', $categoriasReceita);
    }

    public function store(Request $request){
        $receita =  $this->receita;
        $receita->valor = $request->input('valor');
        $receita->descricao = $request->input('descricao');
        $receita->status = $request->input('status');
        $receita->data = $request->input('data');
        $receita->receita_fixa = $request->input('fixa');
        $receita->observacao = $request->input('observacao');
        $receita->conta_id = $request->input('conta');
        $receita->categoria_id = $request->input('categoria');
        $receita->usuario_id = $request->user()->id;

        $receita->save();

        // Atualiza Saldo da Conta Selecionada
        $conta = DB::table('contas')->where('id', '=', $receita->conta_id)->get();
        $valor_atualizado = $receita->valor + (int) $conta[0]->valor;
        DB::table('contas')->where('id', $receita->conta_id)->update(['valor' => $valor_atualizado]);

        return redirect('/receitas')->with('success', 'receita salva com sucesso!');
    }

    public function show(Receita $receita){
        //
    }

    public function edit(Receita $receita){
        $contas = $this->conta::all()->where('usuario_id', '=', Auth::id());
        $categoriasReceita = $this->categoria::all()->where('tipo', 'Receita')->where('usuario_id', '=', Auth::id());
        
        return view('layouts.receitas.cadastrar')->with('receita', $receita)->with('contas', $contas)->with('categoriasReceita', $categoriasReceita);
    }

    public function update(Request $request, Receita $receita){
        // Atualiza Saldo da Conta Selecionada
        $conta = DB::table('contas')->where('id', '=', $receita->conta_id)->get();
        $valor_atualizado = ( (int) $conta[0]->valor - $receita->valor ) + $request->input('valor');
        DB::table('contas')->where('id', $receita->conta_id)->update(['valor' => $valor_atualizado]);

        $receita->valor = $request->input('valor');
        $receita->descricao = $request->input('descricao');
        $receita->status = $request->input('status');
        $receita->data = $request->input('data');
        $receita->receita_fixa = $request->input('fixa');
        $receita->observacao = $request->input('observacao');
        $receita->conta_id = $request->input('conta');
        $receita->categoria_id = $request->input('categoria');
       
        $receita->save();

        return redirect('/receitas')->with('success', 'Receita alterada com sucesso!');
    }

    public function destroy(Receita $receita){
        try {
            $receita->delete();

            // Atualiza Saldo da Conta Selecionada
            $conta = DB::table('contas')->where('id', '=', $receita->conta_id)->get();
            $valor_atualizado = (int) $conta[0]->valor - $receita->valor ;
            DB::table('contas')->where('id', $receita->conta_id)->update(['valor' => $valor_atualizado]);

            return redirect('/receitas')->with('success', 'receita excluida com sucesso!');
        } catch (\Illuminate\Database\QueryException $qe) {
            return ['status' => 'errorQuery', 'message' => $qe->getMessage()];
        } catch (\PDOException $e) {
            return ['status' => 'errorPDO', 'message' => $e->getMessage()];
        }
    }
}
