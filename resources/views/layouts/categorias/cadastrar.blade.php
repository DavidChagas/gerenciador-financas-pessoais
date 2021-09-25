@extends('layouts.app')

@section('content')

@if(isset($categoria))
	<titulo-form-component titulo="Editar Categoria"></titulo-form-component>
	<categoria-form-component action="/categorias/{{$categoria->id}}" method="POST" token="{{ csrf_token() }}" categoria="{{$categoria}}">
		<span slot="method">{{ method_field('PUT') }}</span>
	</categoria-form-component>
@else 
	<titulo-form-component titulo="Cadastrar Categoria"></titulo-form-component>
	<categoria-form-component action="/categorias" method="POST" token="{{ csrf_token() }}" categoria="''"></categoria-form-component>
@endif


@endsection