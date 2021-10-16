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

        $query_datas_receitas = "SELECT date_format(r.data, '%m-%Y') as data
                    from contas c 
                    inner join receitas r on r.conta_id = c.id
                    where c.usuario_id = ?";

        $query_datas_despesas = "SELECT date_format(d.data, '%m-%Y') as data
                    from contas c 
                    inner join despesas d on d.conta_id = c.id
                    where c.usuario_id = ?";

        // $datas_receitas = DB::select($query_datas_receitas, [Auth::id()]);
        // $datas_despesas = DB::select($query_datas_despesas, [Auth::id()]);

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


        return view('layouts/home', compact('datas_receitas', 'datas_despesas'));
    }

    public function teste(Request $request){
        $first = (String) $_GET['first'];
        $last = (String) $_GET['last'];

        $soma_receitas = DB::table('receitas')->select(DB::raw('SUM(valor) AS total_receitas'))->whereBetween('data', ["$first", "$last"])->where('usuario_id', '=', Auth::id())->get();
        $soma_despesas = DB::table('despesas')->select(DB::raw('SUM(valor) AS total_despesas'))->whereBetween('data', ["$first", "$last"])->where('usuario_id', '=', Auth::id())->get();
        
        return [$soma_receitas[0], $soma_despesas[0]];
    }
}
