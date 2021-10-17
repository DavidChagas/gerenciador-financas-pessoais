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
        ->get();

        $datas_despesas = DB::table('despesas')
        ->select('data')
        ->join('contas', function ($join) {
            $join->on('contas.id', '=', 'despesas.conta_id')
                 ->where('contas.usuario_id', '=', Auth::id());
        })
        ->get();
        
        // SALDO TOTAL
        $query_saldo_total_receitas = "select sum(valor) as total from receitas where usuario_id = ?";
        $query_saldo_total_despesas = "select sum(valor) as total from despesas where usuario_id = ?";

        $saldo_total_receitas = DB::select($query_saldo_total_receitas, [Auth::id()]);
        $saldo_total_despesas = DB::select($query_saldo_total_despesas, [Auth::id()]);
        $saldo_total = (int) $saldo_total_receitas[0]->total - (int) $saldo_total_despesas[0]->total;
        
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
