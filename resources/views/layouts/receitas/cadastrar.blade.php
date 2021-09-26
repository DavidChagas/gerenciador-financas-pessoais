@extends('layouts.app')

@section('content')

@if(isset($receita))
	<titulo-form-component titulo="Editar Receita"></titulo-form-component>
	<receita-form-component action="/receitas/{{$receita->id}}" method="POST" token="{{ csrf_token() }}" receita="{{$receita}}">
		<span slot="method">{{ method_field('PUT') }}</span>
	</receita-form-component>
@else 
	<titulo-form-component titulo="Cadastrar Receita"></titulo-form-component>
	<receita-form-component action="/receitas" method="POST" token="{{ csrf_token() }}" receita="''" contas="{{$contas}}" categorias-receita="{{$categoriasReceita}}"></receita-form-component>
@endif


@endsection