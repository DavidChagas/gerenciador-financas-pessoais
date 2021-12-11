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
        $infos = DB::table('receitas')
        ->select('receitas.*', 'contas.descricao as conta', 'categorias.descricao as categoria')
        ->join('contas', function ($join) {
            $join->on('contas.id', '=', 'receitas.conta_id');
        })
        ->join('categorias', function ($join) {
            $join->on('categorias.id', '=', 'receitas.categoria_id');
        })
        ->where('receitas.usuario_id', '=', Auth::id())
        ->get();

        //datas
        $datas_receitas = DB::table('receitas')
        ->select('data')
        ->join('contas', function ($join) {
            $join->on('contas.id', '=', 'receitas.conta_id')
                 ->where('contas.usuario_id', '=', Auth::id());
        })
        ->where('receitas.usuario_id', '=', Auth::id())
        ->orderByDesc('data')
        ->get();

        return view('layouts.receitas.listar', compact('datas_receitas', 'infos'));
    }

    public function create(){
        $contas = $this->conta::all()->where('usuario_id', '=', Auth::id())->where('arquivado', '=', 0);
        $categoriasReceita = $this->categoria::all()->where('tipo', 'Receita')->where('usuario_id', '=', Auth::id())->where('arquivado', '=', 0);
        return view('layouts/receitas/cadastrar')->with('contas', $contas)->with('categoriasReceita', $categoriasReceita);
    }

    public function store(Request $request){
        $request_valor_formatado = (int) preg_replace('/\D/', '', $request->input('valor'));

        if($request->input('fixa') == 'sim' && $request->input('qtd_meses') > 0){
            for ($i=0; $i <= $request->input('qtd_meses'); $i++) { 
                $this->receita = new Receita();

                $receita =  $this->receita;
                $receita->valor = $request_valor_formatado;
                $receita->descricao = $request->input('descricao');
                $receita->status = $i == 0 ? $request->input('status') : 'nao-pago';
                $receita->data = date('Y-m-d', strtotime("+".$i." months", strtotime($request->input('data'))));
                $receita->observacao = $request->input('observacao');
                $receita->conta_id = $request->input('conta');
                $receita->categoria_id = $request->input('categoria');
                $receita->usuario_id = $request->user()->id;

                $receita->save();

                if($receita->status == 'pago'){
                    //Atualiza Saldo da Conta Selecionada
                    $conta = DB::table('contas')->where('id', '=', $receita->conta_id)->get();
                    $valor_atualizado = $receita->valor + (int) $conta[0]->valor;
                    DB::table('contas')->where('id', $receita->conta_id)->update(['valor' => $valor_atualizado]);
                } 
            }

            return redirect('/receitas')->with('success', 'Receitas criadas com sucesso!');
        }else{
            $receita = $this->receita;
            $receita->valor = $request_valor_formatado;
            $receita->descricao = $request->input('descricao');
            $receita->status = $request->input('status');
            $receita->data = $request->input('data');
            $receita->observacao = $request->input('observacao');
            $receita->conta_id = $request->input('conta');
            $receita->categoria_id = $request->input('categoria');
            $receita->usuario_id = $request->user()->id;

            $receita->save();
            
            if($receita->status == 'pago'){
                //Atualiza Saldo da Conta Selecionada
                $conta = DB::table('contas')->where('id', '=', $receita->conta_id)->get();
                $valor_atualizado = $receita->valor + (int) $conta[0]->valor;
                DB::table('contas')->where('id', $receita->conta_id)->update(['valor' => $valor_atualizado]);
            }

            return redirect('/receitas')->with('success', 'Receita criada com sucesso!');
        }
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
        $request_valor_formatado = (int) preg_replace('/\D/', '', $request->input('valor'));

        $status_antigo = $receita->status;
        $status_novo   = $request->input('status');

        if($status_antigo == 'pago' && $status_novo == 'nao-pago'){
            // Apenas diminui da conta antiga
            $contaAntiga = DB::table('contas')->where('id', '=', $receita->conta_id)->get();
            $contaAntigaValor = (int) $contaAntiga[0]->valor - $receita->valor;
            DB::table('contas')->where('id', $contaAntiga[0]->id)->update(['valor' => $contaAntigaValor]);
        }elseif ($status_antigo == 'pago' && $status_novo == 'pago') {
            // Diminui da conta antiga
            $contaAntiga = DB::table('contas')->where('id', '=', $receita->conta_id)->get();
            $contaAntigaValor = (int) $contaAntiga[0]->valor - $receita->valor;
            DB::table('contas')->where('id', $contaAntiga[0]->id)->update(['valor' => $contaAntigaValor]);
            // Soma na conta nova (ou pode ser a mesma, nesse caso atualizando o valor)
            $contaNova = DB::table('contas')->where('id', '=', $request->input('conta'))->get();
            $contaNovaValor = (int) $contaNova[0]->valor + $request_valor_formatado;
            DB::table('contas')->where('id', $contaNova[0]->id)->update(['valor' => $contaNovaValor]);
        }elseif ($status_antigo == 'nao-pago' && $status_novo == 'pago') {
            // Apenas soma na conta nova
            $contaNova = DB::table('contas')->where('id', '=', $request->input('conta'))->get();
            $contaNovaValor = (int) $contaNova[0]->valor + $request_valor_formatado;
            DB::table('contas')->where('id', $contaNova[0]->id)->update(['valor' => $contaNovaValor]);
        }

        $receita->valor = $request_valor_formatado;
        $receita->descricao = $request->input('descricao');
        $receita->status = $request->input('status');
        $receita->data = $request->input('data');
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

            return redirect('/receitas')->with('success', 'Receita excluida com sucesso!');
        } catch (\Illuminate\Database\QueryException $qe) {
            return ['status' => 'errorQuery', 'message' => $qe->getMessage()];
        } catch (\PDOException $e) {
            return ['status' => 'errorPDO', 'message' => $e->getMessage()];
        }
    }

    public function marcarComoPaga(){
        $id_receita = $_GET['idReceita'];
        $id_conta   = $_GET['idConta'];
        $valor      = $_GET['valor'];
        
        $affected = DB::table('receitas')->where('id', $id_receita)->update(['status' => 'pago']);

        // Apenas soma na conta
        $conta = DB::table('contas')->where('id', '=', $id_conta)->get();
        $contaNovoValor = (int) $conta[0]->valor + $valor;
        DB::table('contas')->where('id', $conta[0]->id)->update(['valor' => $contaNovoValor]);

        return;
    }
}
