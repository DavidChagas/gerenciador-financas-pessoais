@extends('layouts.app')

@section('content')


<titulo-form-component titulo="Lista de Contas"></titulo-form-component>
<div style="float: right; margin-bottom: 30px;">
	<a href="{{route('conta.cadastrar')}}" class="btn btn-primary" >Cadastrar Nova Conta</a>
</div>
<listagem-table-component infos="{{ $infos }}" token="{{ csrf_token() }}">
	<span slot="method">
		@csrf
		{{ method_field('DELETE') }}
	</span>
</listagem-table-component>

@endsection