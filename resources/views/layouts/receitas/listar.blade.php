@extends('layouts.app')

@section('content')


<titulo-form-component titulo="Lista de Receitas"></titulo-form-component>

<a href="{{route('receita.cadastrar')}}" class="btn btn-primary" style="margin-bottom: 30px;">Cadastrar Nova Receita</a>

<receita-list-component infos="{{ $infos }}" datas_receitas="{{ $datas_receitas }}" token="{{ csrf_token() }}" model="receitas">
	<span slot="method">
		@csrf
		{{ method_field('DELETE') }}
	</span>
</receita-list-component>

@endsection