<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin area</title>
        <link rel="stylesheet" href="{{asset('src/css/admin.css')}}" type="text/css">
        @yield('styles')
    </head>
    <body>
        @include('includes.admin-header')
        @yield('content')

        <script type="text/javascript">
            var baseUrl = "{{URL::to('/')}}" // da bi se na osnovni url dodavali segmenti
        </script>

        @yield('scripts')
    </body>
</html>