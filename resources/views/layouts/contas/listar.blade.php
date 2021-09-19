@extends('layouts.app')

@section('content')

<titulo-form-component titulo="Lista de Contas"></titulo-form-component>
<listagem-table-component infos="{{ $infos }}"></listagem-table-component>


@endsection