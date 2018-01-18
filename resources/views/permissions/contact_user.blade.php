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
                        Jogok megadása - <a href="{{user_url( $user->id )}}">{{ $user->name }}</a>
                    </div>
                    <div class="card-body">
                        <p>Engedélyezett</p>
                        <ul class="list-unstyled">
                            @foreach($user->permission_list as $permission)
                                <li>
                                    <a href="javascript:window.testerPermission('/permissions/contact_user/delete/{{$user->id}}/{{$permission['id']}}')">
                                        <i class="fa fa-minus"></i>
                                        {{$permission['name']}}
                                        (
                                        <small>{{$permission['description']}}</small>
                                        )
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                                <hr>
                        <p>Tiltott</p>

                        <ul class="list-unstyled">
                            @foreach($permissions as $permission)
                                <li>
                                    <a href="javascript:window.testerPermission('/permissions/contact_user/add/{{$user->id}}/{{$permission['id']}}')">
                                        <i class="fa fa-plus"></i>
                                        {{$permission['name']}}
                                        (
                                        <small>{{$permission['description']}}</small>
                                        )
                                    </a>
                                </li>
                            @endforeach


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
