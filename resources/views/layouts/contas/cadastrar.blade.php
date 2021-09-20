@extends('layouts.app')

@section('content')

@if(isset($conta))
	<titulo-form-component titulo="Editar Conta"></titulo-form-component>
	<conta-form-component token="{{ csrf_token() }}" conta="{{$conta}}"></conta-form-component>
@else 
	<titulo-form-component titulo="Cadastrar Conta"></titulo-form-component>
	<conta-form-component token="{{ csrf_token() }}"></conta-form-component>
@endif


@endsection