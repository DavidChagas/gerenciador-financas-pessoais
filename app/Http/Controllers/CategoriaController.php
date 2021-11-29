<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        try {
            $categoria->delete();
            return redirect('/categorias')->with('success', 'Categoria excluída com sucesso!');
        } catch (\Illuminate\Database\QueryException $qe) {
            return redirect('/categorias')->with('error', 'Categoria não pode ser excluída!');
            // return ['status' => 'errorQuery', 'message' => $qe->getMessage()];
        } catch (\PDOException $e) {
            return redirect('/categorias')->with('error', 'Categoria não pode ser excluída, algo inesperado aconteceu.');
            // return ['status' => 'errorPDO', 'message' => $e->getMessage()];
        }
    }
}
