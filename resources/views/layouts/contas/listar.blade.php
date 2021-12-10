@extends('layouts.app')

@section('content')


<titulo-form-component titulo="Lista de Contas"></titulo-form-component>

<a href="{{route('conta.cadastrar')}}" class="btn btn-success" style="margin-bottom: 30px;">Cadastrar Nova Conta</a>

<conta-list-component infos="{{ $infos }}" token="{{ csrf_token() }}" model="contas">
	<span slot="method">
		@csrf
		{{ method_field('DELETE') }}
	</span>
</conta-list-component>

@endsection