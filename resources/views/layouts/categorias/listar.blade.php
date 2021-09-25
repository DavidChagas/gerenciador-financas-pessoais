@extends('layouts.app')

@section('content')


<titulo-form-component titulo="Lista de Categorias"></titulo-form-component>

<a href="{{route('categoria.cadastrar')}}" class="btn btn-primary" style="margin-bottom: 30px;">Cadastrar Nova Categoria</a>

<listagem-table-component infos="{{ $infos }}" token="{{ csrf_token() }}" model="categorias">
	<span slot="method">
		@csrf
		{{ method_field('DELETE') }}
	</span>
</listagem-table-component>

@endsection