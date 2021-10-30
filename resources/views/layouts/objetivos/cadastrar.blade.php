@extends('layouts.app')

@section('content')

@if(isset($objetivo))
	<titulo-form-component titulo="Editar Objetivo"></titulo-form-component>
	<objetivo-form-component action="/objetivos/{{$objetivo->id}}" method="POST" token="{{ csrf_token() }}" objetivo="{{$objetivo}}">
		<span slot="method">{{ method_field('PUT') }}</span>
	</objetivo-form-component>
@else 
	<titulo-form-component titulo="Cadastrar Objetivo"></titulo-form-component>
	<objetivo-form-component action="/objetivos" method="POST" token="{{ csrf_token() }}" objetivo="''"></objetivo-form-component>
@endif


@endsection