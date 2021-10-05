@extends('layouts.app')

@section('content')

@if(isset($despesa))
	<titulo-form-component titulo="Editar Despesa"></titulo-form-component>
	<despesa-form-component action="/despesas/{{$despesa->id}}" method="POST" token="{{ csrf_token() }}" despesa="{{$despesa}}" contas="{{$contas}}" categorias-despesa="{{$categoriasDespesa}}">
		<span slot="method">{{ method_field('PUT') }}</span>
	</despesa-form-component>
@else 
	<titulo-form-component titulo="Cadastrar Despesa"></titulo-form-component>
	<despesa-form-component action="/despesas" method="POST" token="{{ csrf_token() }}" despesa="''" contas="{{$contas}}" categorias-despesa="{{$categoriasDespesa}}"></despesa-form-component>
@endif


@endsection