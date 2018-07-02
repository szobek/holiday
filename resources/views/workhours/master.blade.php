<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('elements',["css" => true])
    <title>Calendar | @yield('title')</title>

    <link rel="icon" href="/assets/logo.png" type="image/png">
    <link rel="shortcut icon" href="/assets/logo.png" type="image/png">

</head>
<body>


@yield('content')


@include('elements',["js" => true])


</body>

</html>
