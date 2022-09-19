<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="{{ asset('js/ajax-add-comment.js') }}" defer></script>
    <script src="{{ asset('js/show-more.js') }}" defer></script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand mx-5" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <form class="input-group" action="{{ route('search') }}" method="GET">
                <input class="search form-control w-75" type="text" name="search" placeholder="Поиск по новостям и категориям">
                <span class="mx-1"><button type="submit" class="btn btn-info" id="search-button">Найти</button></span>
            </form>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li>
                    </li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                            </li>
                        @endif
{{--TODO убрать регистрацию из открытого доступа, оставить только вход для админов или сделать по инвайту--}}
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('auth.logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm pb-0">
        <div class="container text-center mb-2">
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('news.create') }}">
                            Добавить новость
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('category.create') }}">
                            Добавить категорию
                        </a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('category.index') }}">
                        Категории
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('news.index') }}">
                        Новости всех категорий
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tag.index') }}">
                        Обсуждаемые темы
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <main class="py-4 px-4 container" style="margin-left: 550px;">
        @yield('content')
    </main>
</div>
</body>
</html>
