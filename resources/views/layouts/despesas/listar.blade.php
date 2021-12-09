@extends('layouts.app')

@section('content')

<div class="d-print-none">
	<titulo-form-component titulo="Lista de Despesas"></titulo-form-component>
</div>
<div class="d-print-block" style="display:none">
	<titulo-form-component titulo="Relatório de Despesas"></titulo-form-component>
</div>

<a href="{{route('despesa.cadastrar')}}" class="btn btn-primary d-print-none" style="margin-bottom: 40px;">Cadastrar Nova Despesa</a>

<despesa-list-component infos="{{ $infos }}" datas_despesas="{{ $datas_despesas }}" token="{{ csrf_token() }}" model="despesas">
	<!-- <span slot="method">
		@csrf
		{{ method_field('DELETE') }}
	</span> -->
</list-component>

@endsection