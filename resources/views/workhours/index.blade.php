@extends('workhours/master')


@section('content')

    <div class="container" id="wh-ci-container">
        <div class="row">
            <div class="col-md-12">


                <div class="card">
                    <div class="card-header">
                        Érkezés / Távozás
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}


                                    <div class="form-group">
                                        <label for="user" class="col-md-4 control-label">Azonosító</label>

                                        <div class="col-md-6 offset-3 ">
                                            <select name="user" id="user" class="form-control">
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>






                                </form>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary" id="incoming">
                                    Érkezés
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger" id="outgoing">
                                    Távozás
                                </button>
                            </div>


                        </div>



                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">

            </div>
        </div>

    </div>



@endsection
