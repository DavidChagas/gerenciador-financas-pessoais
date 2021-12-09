@extends('layouts.app')

@section('content')
<div class="panel-login">
    <div class="titulo">
        Gerenciador de Finanças Pessoais
    </div>
    <form method="POST" action="{{ route('login') }}" autocomplete="off">
        @csrf

        <div class="form-group">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Seu e-mail" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Sua senha" name="password" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div> -->

        <div class="form-group">
            
            <button type="submit" class="btn btn-block btn-primary" style="margin-top: 10px;height: 46px;font-size: 22px;">
            <i class="fas fa-sign-in-alt"></i> {{ __('Entrar') }}
            </button>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-link" style="color: #90979d; margin-top: 10px">Não tenho Conta</a>
            @endif

            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}" style="float: right; color: #90979d; margin-top: 10px">
                    {{ __('Esqueci minha Senha') }} <i class="far fa-frown"></i>
                </a>
            @endif
            
        </div>
    </form>
</div>
@endsection
