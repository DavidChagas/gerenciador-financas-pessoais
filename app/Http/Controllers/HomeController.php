<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller{
    private $meses;

    public function __construct(){
        
    }

    public function index(){          

        // DATAS
        $datas_receitas = DB::table('receitas')
        ->select('data')
        ->join('contas', function ($join) {
            $join->on('contas.id', '=', 'receitas.conta_id')
                 ->where('contas.usuario_id', '=', Auth::id());
        })
        ->orderByDesc('data')
        ->get();

        $datas_despesas = DB::table('despesas')
        ->select('data')
        ->join('contas', function ($join) {
            $join->on('contas.id', '=', 'despesas.conta_id')
                 ->where('contas.usuario_id', '=', Auth::id());
        })
        ->orderByDesc('data')
        ->get();
        
        // SALDO TOTAL
        $query_saldo_total = "select sum(valor) as total from contas where usuario_id = ?";

        $saldo_total = DB::select($query_saldo_total, [Auth::id()]);
        
        $saldo_total = (int) $saldo_total[0]->total;
        
        return view('layouts/home', compact('datas_receitas', 'datas_despesas', 'saldo_total'));
    }

    public function getTotais(Request $request){
        $first = (String) $_GET['first'];
        $last = (String) $_GET['last'];

        $soma_receitas = DB::table('receitas')->select(DB::raw('SUM(valor) AS total_receitas'))->whereBetween('data', ["$first", "$last"])->where('usuario_id', '=', Auth::id())->get();
        $soma_despesas = DB::table('despesas')->select(DB::raw('SUM(valor) AS total_despesas'))->whereBetween('data', ["$first", "$last"])->where('usuario_id', '=', Auth::id())->get();
        
        return [$soma_receitas[0], $soma_despesas[0]];
    }

    public function getTotaisCategorias(Request $request){
        $first = (String) $_GET['first'];
        $last = (String) $_GET['last'];

        $soma_categoria_receitas = DB::table('receitas')
        ->select(DB::raw('SUM(receitas.valor) AS soma'), 'categorias.descricao')
        ->join('categorias', 'categorias.id', '=', 'receitas.categoria_id')
        ->whereBetween('receitas.data', ["$first", "$last"])
        ->where('receitas.usuario_id', '=', Auth::id())
        ->groupBy('receitas.categoria_id', 'categorias.descricao')
        ->orderByRaw('receitas.valor DESC')
        ->get();

        $soma_categoria_despesas = DB::table('despesas')
        ->select(DB::raw('SUM(despesas.valor) AS soma'), 'categorias.descricao')
        ->join('categorias', 'categorias.id', '=', 'despesas.categoria_id')
        ->whereBetween('despesas.data', ["$first", "$last"])
        ->where('despesas.usuario_id', '=', Auth::id())
        ->groupBy('despesas.categoria_id', 'categorias.descricao')
        ->orderByRaw('despesas.valor DESC')
        ->get();
        
        return [$soma_categoria_receitas, $soma_categoria_despesas];
    }

    public function getPendencias(){
        $first = (String) $_GET['first'];
        $last = (String) $_GET['last'];

        $receitas_pendentes = DB::table('receitas')->select('*')->whereBetween('data', ["$first", "$last"])->where('usuario_id', '=', Auth::id())->where('status', '=', 'nao-pago')->get();
        $despesas_pendentes = DB::table('despesas')->select('*')->whereBetween('data', ["$first", "$last"])->where('usuario_id', '=', Auth::id())->where('status', '=', 'nao-pago')->get();
        
        return [$receitas_pendentes, $despesas_pendentes];
    }
}
