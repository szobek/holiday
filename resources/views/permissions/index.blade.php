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
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="card">

                    <div class="card-header">
                        <h4 class="h4">Jogok</h4>
                    </div>

                    <div class="card-body">


                        <ul class="list-unstyled">
                            @foreach($permissions as $permission)
                                <li>
                                    <a href="/permissions/{{ $permission['id'] }}">{{$permission['name']}} <small>{{ $permission['description'] }}</small></a>
                                </li>
                            @endforeach
                        </ul>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
