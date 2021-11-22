@extends('layouts.app')

@section('content')
<div class="panel-login">
    <div class="titulo">
        Cadastro
    </div>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Seu nome" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            
        </div>

        <div class="form-group">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Seu e-mail" name="email" value="{{ old('email') }}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Sua senha" name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group ">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirme sua senha" required autocomplete="new-password">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                {{ __('Cadastrar') }}
            </button>
            <a href="{{ route('login') }}" class="ml-4 text-sm text-gray-700 underline">Voltar</a>
        </div>
    </form>
</div>
@endsection
