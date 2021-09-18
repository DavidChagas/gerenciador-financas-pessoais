@extends('layouts.app')

@section('content')

<titulo-form-component titulo="Cadastro de Contas"></titulo-form-component>

<conta-form-component token="{{ csrf_token() }}"></conta-form-component>

@endsection