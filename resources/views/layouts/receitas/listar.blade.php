@extends('layouts.app')

@section('content')


<titulo-form-component titulo="Lista de Receitas"></titulo-form-component>

<a href="{{route('receita.cadastrar')}}" class="btn btn-primary" style="margin-bottom: 30px;">Cadastrar Nova Receita</a>

<listagem-table-component infos="{{ $infos }}" token="{{ csrf_token() }}" model="receitas">
	<span slot="method">
		@csrf
		{{ method_field('DELETE') }}
	</span>
</listagem-table-component>

@endsection