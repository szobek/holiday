<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('elements',["css" => true])
        <title>Calendar | @yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

        <link rel="icon" href="/assets/logo.png" type="image/png">
        <link rel="shortcut icon" href="/assets/logo.png" type="image/png">

        <script>
            window.me = {!! json_encode(\Illuminate\Support\Facades\Auth::user()->id)!!};

        </script>

    </head>
    <body>

        @include('nav.index')
        @include('list.message')

        @yield('content')

    </body>
    @include('elements',["js" => true])
    @yield('sub_js')








</html>
