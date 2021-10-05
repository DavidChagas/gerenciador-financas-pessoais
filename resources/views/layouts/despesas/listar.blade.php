@extends('layouts.app')

@section('content')


<titulo-form-component titulo="Lista de Despesas"></titulo-form-component>

<a href="{{route('despesa.cadastrar')}}" class="btn btn-primary" style="margin-bottom: 30px;">Cadastrar Nova Despesa</a>

<listagem-table-component infos="{{ $infos }}" token="{{ csrf_token() }}" model="despesas">
	<span slot="method">
		@csrf
		{{ method_field('DELETE') }}
	</span>
</listagem-table-component>

@endsection