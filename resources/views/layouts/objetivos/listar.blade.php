@extends('layouts.app')

@section('content')


<titulo-form-component titulo="Lista de Objetivos"></titulo-form-component>

<a href="{{route('objetivo.cadastrar')}}" class="btn btn-primary" style="margin-bottom: 30px;">Cadastrar Novo Objetivo</a>

<objetivo-list-component infos="{{ $objetivos }}" token="{{ csrf_token() }}" model="objetivos">
	<span slot="method">
		@csrf
		{{ method_field('DELETE') }}
	</span>
</objetivo-list-component>

@endsection