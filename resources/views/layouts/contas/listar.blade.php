@extends('layouts.app')

@section('content')


<titulo-form-component titulo="Lista de Contas"></titulo-form-component>

<a href="{{route('conta.cadastrar')}}" class="btn btn-primary" style="margin-bottom: 30px;">Cadastrar Nova Conta</a>

<listagem-table-component infos="{{ $infos }}" token="{{ csrf_token() }}">
	<span slot="method">
		@csrf
		{{ method_field('DELETE') }}
	</span>
</listagem-table-component>

@endsection