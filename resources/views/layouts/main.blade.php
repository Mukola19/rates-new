<!DOCTYPE html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>

<head>
    <meta charset='utf-8'>
    <link rel='stylesheet' href='{{ asset('dist/bootstrap-5/css/bootstrap.min.css') }}'>
    <link rel='stylesheet' href='{{ asset('css/app.css') }}'>
    <link rel='icon' type='image/x-icon' href='{{ asset('assets/favicon.png') }}'>
    @vite('resources/css/app.css')
    <title>@yield('title')</title>
</head>
<div class='wrapper'>
    {{-- Navbar --}}
    <nav class='navbar navbar-expand-lg bg-light'>
        <div class='container-fluid'>
            <a class='navbar-brand' href='{{ url('/') }}'>Rates</a>
            <div class='collapse navbar-collapse'>
                <ul class='navbar-nav'>
                    <li class='nav-item '>
                        <a class='nav-link navItemLink ' href='{{ route('convector') }}'>Конвектор</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    {{-- Content --}}
    @yield('content')
</div>


<script src='{{ asset('dist/bootstrap-5/js/bootstrap.bundle.min.js') }}'></script>
<script src='{{ asset('js/main.js') }}'></script>
@vite('resources/js/app.js')

</body>

</html>
