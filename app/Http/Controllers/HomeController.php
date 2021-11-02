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

    public function teste(Request $request){
        $first = (String) $_GET['first'];
        $last = (String) $_GET['last'];

        $soma_receitas = DB::table('receitas')->select(DB::raw('SUM(valor) AS total_receitas'))->whereBetween('data', ["$first", "$last"])->where('usuario_id', '=', Auth::id())->get();
        $soma_despesas = DB::table('despesas')->select(DB::raw('SUM(valor) AS total_despesas'))->whereBetween('data', ["$first", "$last"])->where('usuario_id', '=', Auth::id())->get();
        
        return [$soma_receitas[0], $soma_despesas[0]];
    }
}
