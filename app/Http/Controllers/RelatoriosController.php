<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RelatoriosController extends Controller{
    private $meses;

    public function __construct(){
        
    }

    public function getRelatorios(Request $request){
        $relatorio = $_GET['relatorio'];
        $first = (String) $_GET['first'];
        $last = (String) $_GET['last'];

        switch ($relatorio) {
            case 'despesas-por-categoria':
                $colunas = ['Categoria', 'Total'];
                $linhas = DB::table('despesas')
                ->select(DB::raw('SUM(despesas.valor) AS Total'), 'categorias.descricao as Categoria')
                ->join('categorias', 'categorias.id', '=', 'despesas.categoria_id')
                ->whereBetween('despesas.data', ["$first", "$last"])
                ->where('despesas.usuario_id', '=', Auth::id())
                ->groupBy('despesas.categoria_id', 'categorias.descricao')
                ->orderByRaw('despesas.valor DESC')
                ->get();
                break;
            
            case 'receitas-por-categoria':
                $colunas = ['Categoria', 'Total'];
                $linhas = DB::table('receitas')
                ->select(DB::raw('SUM(receitas.valor) AS Total'), 'categorias.descricao as Categoria')
                ->join('categorias', 'categorias.id', '=', 'receitas.categoria_id')
                ->whereBetween('receitas.data', ["$first", "$last"])
                ->where('receitas.usuario_id', '=', Auth::id())
                ->groupBy('receitas.categoria_id', 'categorias.descricao')
                ->orderByRaw('receitas.valor DESC')
                ->get();
                break;
            case 'despesas-por-conta':
                $colunas = ['Conta', 'Total'];
                $linhas = DB::table('despesas')
                ->select(DB::raw('SUM(despesas.valor) AS Total'), 'contas.descricao as Conta')
                ->join('contas', 'contas.id', '=', 'despesas.conta_id')
                ->whereBetween('despesas.data', ["$first", "$last"])
                ->where('despesas.usuario_id', '=', Auth::id())
                ->groupBy('despesas.conta_id', 'contas.descricao')
                ->orderByRaw('despesas.valor DESC')
                ->get();
                break;
            case 'receitas-por-conta':
                $colunas = ['Conta', 'Total'];
                $linhas = DB::table('receitas')
                ->select(DB::raw('SUM(receitas.valor) AS Total'), 'contas.descricao as Conta')
                ->join('contas', 'contas.id', '=', 'receitas.conta_id')
                ->whereBetween('receitas.data', ["$first", "$last"])
                ->where('receitas.usuario_id', '=', Auth::id())
                ->groupBy('receitas.conta_id', 'contas.descricao')
                ->orderByRaw('receitas.valor DESC')
                ->get();
                break;
            case 'balanco-mensal':
                $colunas = ['Total Receitas', 'Total Despesas'];
                $linha1 = DB::table('receitas')
                ->select(DB::raw('SUM(receitas.valor) AS "Total"'))
                ->whereBetween('receitas.data', ["$first", "$last"])
                ->where('receitas.usuario_id', '=', Auth::id())
                ->get();

                $linha2 = DB::table('despesas')
                ->select(DB::raw('SUM(despesas.valor) AS "Total"'))
                ->whereBetween('despesas.data', ["$first", "$last"])
                ->where('despesas.usuario_id', '=', Auth::id())
                ->get();

                $linhas = json_decode(json_encode($linha1), true);
                $x = json_decode(json_encode($linha2), true)[0];
                
                array_push($linhas, $x);
                
                $linhas = json_decode(json_encode($linhas), false);

                break;
        }

        
        
        return [$linhas, $colunas];
    }
}
