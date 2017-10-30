<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('elements',["css" => true])
        <title>Calendar</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    <body>

        @include('nav.index')
        @include('list.message')

        @yield('content')



    </body>
    @include('elements',["js" => true])
    @yield('sub_js')




</html>
