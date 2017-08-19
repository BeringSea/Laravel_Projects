<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{asset('src/css/main.css')}}" type="text/css">
        @yield('styles')
    </head>
    <body>
        @include('includes.header')
        <div class="main">
            @yield('content')
        </div>
        @include('includes.footer')
    </body>
</html>