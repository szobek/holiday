@extends('master')

@section('sub_js')
@endsection

@section('sub_css')
@endsection

@section('title')

@endsection

@section('description')

@endsection

@section('content')
    Önnek nincs joga
    <a href="/">Vissza a főoldalra</a>
    <pre>
    {{ $exception->getMessage() }}
    {{ dd2(session()->all()) }}
    </pre>
@endsection
