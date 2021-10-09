@extends('layouts.app')

@section('content')

<home-component datas_receitas="{{$datas_receitas}}" datas_despesas="{{$datas_despesas}}"></home-component>
            
@endsection
