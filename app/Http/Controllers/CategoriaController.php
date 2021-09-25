<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller{

    private $categoria;

    public function __construct(){
        $this->categoria = new Categoria();
    }
    
    public function index(){
        $categorias = $this->categoria::all();
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

        return redirect('/categorias')->with('success', 'categoria salva com sucesso!');
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

        return redirect('/categorias')->with('success', 'categoria alterada com sucesso!');
    }

    public function destroy(Categoria $categoria){
        try {
            $categoria->delete();
            return redirect('/categorias')->with('success', 'categoria excluida com sucesso!');
        } catch (\Illuminate\Database\QueryException $qe) {
            return ['status' => 'errorQuery', 'message' => $qe->getMessage()];
        } catch (\PDOException $e) {
            return ['status' => 'errorPDO', 'message' => $e->getMessage()];
        }
    }
}
