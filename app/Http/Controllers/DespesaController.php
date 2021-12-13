<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Conta;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // $despesas = $this->despesa::all()->where('usuario_id', '=', Auth::id());
        $infos = DB::table('despesas')
        ->select('despesas.*', 'contas.descricao as conta', 'categorias.descricao as categoria')
        ->join('contas', function ($join) {
            $join->on('contas.id', '=', 'despesas.conta_id');
        })
        ->join('categorias', function ($join) {
            $join->on('categorias.id', '=', 'despesas.categoria_id');
        })
        ->where('despesas.usuario_id', '=', Auth::id())
        ->get();

        //datas
        $datas_despesas = DB::table('despesas')
        ->select('data')
        ->join('contas', function ($join) {
            $join->on('contas.id', '=', 'despesas.conta_id')
                 ->where('contas.usuario_id', '=', Auth::id());
        })
        ->where('despesas.usuario_id', '=', Auth::id())
        ->orderByDesc('data')
        ->get();

        return view('layouts.despesas.listar', compact('datas_despesas', 'infos'));
    }

    public function create(){
        $contas = $this->conta::all()->where('usuario_id', '=', Auth::id())->where('arquivado', '=', 0);
        $categoriasDespesa = $this->categoria::all()->where('tipo', 'Despesa')->where('usuario_id', '=', Auth::id())->where('arquivado', '=', 0);
        return view('layouts/despesas/cadastrar')->with('contas', $contas)->with('categoriasDespesa', $categoriasDespesa);
    }

    public function store(Request $request){
        $request_valor_formatado = (int) preg_replace('/\D/', '', $request->input('valor'));

        if($request->input('fixa') == 'sim' && $request->input('qtd_meses') > 0){
            for ($i=0; $i <= $request->input('qtd_meses'); $i++) { 
                $this->despesa = new Despesa();

                $despesa =  $this->despesa;
                $despesa->valor = $request_valor_formatado;
                $despesa->descricao = $request->input('descricao');
                $despesa->status = $i == 0 ? $request->input('status') : 'nao-pago';
                $despesa->data = date('Y-m-d', strtotime("+".$i." months", strtotime($request->input('data'))));
                $despesa->observacao = $request->input('observacao');
                $despesa->conta_id = $request->input('conta');
                $despesa->categoria_id = $request->input('categoria');
                $despesa->usuario_id = $request->user()->id;

                $despesa->save();

                if($despesa->status == 'pago'){
                    //Atualiza Saldo da Conta Selecionada
                    $conta = DB::table('contas')->where('id', '=', $despesa->conta_id)->get();
                    $valor_atualizado = (int) $conta[0]->valor - $despesa->valor;
                    DB::table('contas')->where('id', $despesa->conta_id)->update(['valor' => $valor_atualizado]);
                }
            }

            return redirect('/despesas')->with('success', 'Despesas criadas com sucesso!');
        }else{
            $despesa = $this->despesa;
            $despesa->valor = $request_valor_formatado;
            $despesa->descricao = $request->input('descricao');
            $despesa->status = $request->input('status');
            $despesa->data = $request->input('data');
            $despesa->observacao = $request->input('observacao');
            $despesa->conta_id = $request->input('conta');
            $despesa->categoria_id = $request->input('categoria');
            $despesa->usuario_id = $request->user()->id;

            $despesa->save();

            if($despesa->status == 'pago'){
                //Atualiza Saldo da Conta Selecionada
                $conta = DB::table('contas')->where('id', '=', $despesa->conta_id)->get();
                $valor_atualizado = (int) $conta[0]->valor - $despesa->valor;
                DB::table('contas')->where('id', $despesa->conta_id)->update(['valor' => $valor_atualizado]);
            }

            return redirect('/despesas')->with('success', 'Despesa criada com sucesso!');
        }
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
        $request_valor_formatado = (int) preg_replace('/\D/', '', $request->input('valor'));

        $status_antigo = $despesa->status;
        $status_novo   = $request->input('status');

        if($status_antigo == 'pago' && $status_novo == 'nao-pago'){
            // Apenas soma na conta nova
            $contaAntiga = DB::table('contas')->where('id', '=', $despesa->conta_id)->get();
            $contaAntigaValor = (int) $contaAntiga[0]->valor + $despesa->valor;
            DB::table('contas')->where('id', $contaAntiga[0]->id)->update(['valor' => $contaAntigaValor]);
        }elseif ($status_antigo == 'pago' && $status_novo == 'pago') {
            // Soma da conta antiga
            $contaAntiga = DB::table('contas')->where('id', '=', $despesa->conta_id)->get();
            $contaAntigaValor = (int) $contaAntiga[0]->valor + $despesa->valor;
            DB::table('contas')->where('id', $contaAntiga[0]->id)->update(['valor' => $contaAntigaValor]);
            // Diminui na conta nova (ou pode ser a mesma, nesse caso atualizando o valor)
            $contaNova = DB::table('contas')->where('id', '=', $request->input('conta'))->get();
            $contaNovaValor = (int) $contaNova[0]->valor - $request_valor_formatado;
            DB::table('contas')->where('id', $contaNova[0]->id)->update(['valor' => $contaNovaValor]);
        }elseif ($status_antigo == 'nao-pago' && $status_novo == 'pago') {
            // Apenas diminui da conta antiga
            $contaNova = DB::table('contas')->where('id', '=', $request->input('conta'))->get();
            $contaNovaValor = (int) $contaNova[0]->valor - $request_valor_formatado;
            DB::table('contas')->where('id', $contaNova[0]->id)->update(['valor' => $contaNovaValor]);
        }

        $despesa->valor = $request_valor_formatado;
        $despesa->descricao = $request->input('descricao');
        $despesa->status = $request->input('status');
        $despesa->data = $request->input('data');
        $despesa->observacao = $request->input('observacao');
        $despesa->conta_id = $request->input('conta');
        $despesa->categoria_id = $request->input('categoria');
       
        $despesa->save();

        return redirect('/despesas')->with('success', 'Despesa alterada com sucesso!');
    }

    public function destroy(Despesa $despesa){
        try {
            $despesa->delete();

            if($despesa->status == 'pago'){
                // Atualiza Saldo da Conta Selecionada
                $conta = DB::table('contas')->where('id', '=', $despesa->conta_id)->get();
                $valor_atualizado = (int) $conta[0]->valor + $despesa->valor ;
                DB::table('contas')->where('id', $despesa->conta_id)->update(['valor' => $valor_atualizado]);
            }

            return redirect('/despesas')->with('success', 'Despesa excluida com sucesso!');
        } catch (\Illuminate\Database\QueryException $qe) {
            return ['status' => 'errorQuery', 'message' => $qe->getMessage()];
        } catch (\PDOException $e) {
            return ['status' => 'errorPDO', 'message' => $e->getMessage()];
        }
    }

    public function marcarComoPaga(){
        $id_despesa = $_GET['idDespesa'];
        $id_conta   = $_GET['idConta'];
        $valor      = $_GET['valor'];
        
        $affected = DB::table('despesas')->where('id', $id_despesa)->update(['status' => 'pago']);

        // Diminui da conta
        $conta = DB::table('contas')->where('id', '=', $id_conta)->get();
        $contaNovoValor = (int) $conta[0]->valor - $valor;
        DB::table('contas')->where('id', $conta[0]->id)->update(['valor' => $contaNovoValor]);

        return;
    }
}
