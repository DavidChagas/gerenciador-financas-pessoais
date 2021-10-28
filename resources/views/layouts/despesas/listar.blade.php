@extends('layouts.app')

@section('content')


<titulo-form-component titulo="Lista de Despesas"></titulo-form-component>

<a href="{{route('despesa.cadastrar')}}" class="btn btn-primary" style="margin-bottom: 30px;">Cadastrar Nova Despesa</a>

<despesa-list-component infos="{{ $infos }}" datas_despesas="{{ $datas_despesas }}" token="{{ csrf_token() }}" model="despesas">
	<span slot="method">
		@csrf
		{{ method_field('DELETE') }}
	</span>
</list-component>

@endsection