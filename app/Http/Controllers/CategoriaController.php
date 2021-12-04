<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller{

    private $categoria;

    public function __construct(){
        $this->categoria = new Categoria();
    }
    
    public function index(){
        $categorias = $this->categoria::all()->where('usuario_id', '=', Auth::id());;
        return view('layouts.categorias.listar')->with('infos', $categorias);
    }

    public function create(){
        return view('layouts/categorias/cadastrar');
    }

    public function store(Request $request){
        $categoria =  $this->categoria;
        $categoria->descricao = $request->input('descricao');
        $categoria->tipo = $request->input('tipo');
        $categoria->usuario_id = $request->user()->id;

        $categoria->save();

        return redirect('/categorias')->with('success', 'Categoria salva com sucesso!');
    }

    public function show(Categoria $categoria){
        dd($categoria);
    }

    public function edit(Categoria $categoria){
        return view('layouts.categorias.cadastrar')->with('categoria', $categoria);
    }

    public function update(Request $request, Categoria $categoria){
        $categoria->descricao = $request->input('descricao');
        $categoria->tipo = $request->input('tipo');
       
        $categoria->save();

        return redirect('/categorias')->with('success', 'Categoria alterada com sucesso!');
    }

    public function destroy(Categoria $categoria){
        $categoria->arquivado = 1;

        $categoria->save();

        return redirect('/categorias')->with('success', 'Categoria arquivada com sucesso!');
    }

    public function reativarCategoria(){
        $id_categoria = $_GET['idCategoria'];
        
        $affected = DB::table('categorias')
              ->where('id', $id_categoria)
              ->update(['arquivado' => 0]);

        return;
    }
}
