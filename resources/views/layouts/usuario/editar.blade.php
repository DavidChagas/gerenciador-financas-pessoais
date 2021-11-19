@extends('layouts.app')

@section('content')

	<titulo-form-component titulo="Meus Dados"></titulo-form-component>
    
	<usuario-form-component action="/usuario/{{$usuario->id}}" method="POST" token="{{ csrf_token() }}" usuario="{{$usuario}}">
		<span slot="method">{{ method_field('PUT') }}</span>
	</usuario-form-component>

@endsection