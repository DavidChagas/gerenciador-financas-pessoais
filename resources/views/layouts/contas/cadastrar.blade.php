@extends('layouts.app')

@section('content')

@if(isset($conta))
	<titulo-form-component titulo="Editar Conta"></titulo-form-component>
	<conta-form-component action="/contas/{{$conta->id}}" method="POST" token="{{ csrf_token() }}" conta="{{$conta}}">
		<span slot="method">{{ method_field('PUT') }}</span>
	</conta-form-component>
@else 
	<titulo-form-component titulo="Cadastrar Conta"></titulo-form-component>
	<conta-form-component action="/contas" method="POST" token="{{ csrf_token() }}" conta="''"></conta-form-component>
@endif


@endsection