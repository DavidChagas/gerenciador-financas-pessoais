<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @auth
        <div id="app">
            <div class="menu-lateral">
                <menu-component nome-usuario="{{Auth::user()->nome}}">
                    <span slot="method">@csrf</span>
                </menu-component>
            </div>
            <div class="pagina">
                @yield('content')
            </div>
        </div>
    @else
        <div id="app-login">
            <div class="pagina">
                @yield('content')
            </div>
        </div>
    @endauth
</body>
</html>
