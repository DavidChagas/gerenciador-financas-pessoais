@extends('layouts.app')

@section('content')

<div class="d-print-none">
	<titulo-form-component titulo="Lista de Receitas"></titulo-form-component>
</div>
<div class="d-print-block" style="display:none">
	<titulo-form-component titulo="Relatório de Receitas"></titulo-form-component>
</div>

<a href="{{route('receita.cadastrar')}}" class="btn btn-primary d-print-none" style="margin-bottom: 40px;">Cadastrar Nova Receita</a>

<receita-list-component infos="{{ $infos }}" datas_receitas="{{ $datas_receitas }}" token="{{ csrf_token() }}" model="receitas">
	<!-- <span slot="method">
		@csrf
		{{ method_field('DELETE') }}
	</span> -->
</receita-list-component>

@endsection