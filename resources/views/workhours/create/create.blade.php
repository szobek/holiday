@extends('master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h5 class="text-center">Új felvitel</h5>
                <a href="/workhours">Vissza</a>
            </div>
            <div class="col-12">
                <form id="whForm" action="/workhours/new" method="post">
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

                    <input type="text" name="incoming" id="" class="datetimepicker incoming" data-target="incoming-date" autocomplete="off">
                    <input type="text" name="outgoing" id="" class="datetimepicker outgoing" data-target="outgoing-date" autocomplete="off">

                    {{ csrf_field() }}
                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>

@endsection
