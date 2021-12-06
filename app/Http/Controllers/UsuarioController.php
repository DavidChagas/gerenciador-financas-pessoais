<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller{
    private $usuario;

    public function __construct(){
        $this->usuario = new User();
    }

    public function index(){
        
    }

    public function listar()
    {
        return \Response::json(User::all());
    }
    public function create(){
        
    }

    public function store(Request $request){
      
    }

    public function show($id){
        
    }

    public function edit(){
        $usuario = $this->usuario::all()->where('id', '=', Auth::id());
        
        return view('layouts.usuario.editar')->with('usuario', $usuario[0]);
    }

    public function update(Request $request, User $usuario){
        $usuario->nome = $request->input('nome');
        $usuario->email = $request->input('email');

        if( strlen($request->input('senha')) > 2 ){
            $usuario->password = Hash::make($request->input('senha'));
        }
       
        $usuario->save();

        return redirect('/')->with('success', 'Usuário alterado com sucesso!');
    }

    public function destroy($id){
        
    }
}
