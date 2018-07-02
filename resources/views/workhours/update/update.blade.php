@extends('master')


@section('content')


    <div class="container">
        <div class="row">
            <div class="col-12">
                <h5 class="text-center">{{ $data['user']->name }}</h5>
                <a href="/workhours">Vissza</a>
            </div>
            <div class="col-12">
                <form id="whForm" action="/workhours/edit/{{$data['id']}}" method="post">

                    <input type="text" name="incoming-date" id="" class="datetimepicker incoming" data-target="incoming-date" value="{{ $data['incomingDate'] }}" autocomplete="off">
                    <input type="hidden" name="incoming" id="incoming-date"  value="{{ $data['incomingDate'] }}">
                    <input type="text" name="outgoing-date" id="" class="datetimepicker outgoing" data-target="outgoing-date" value="{{ $data['outgoingDate'] }}" autocomplete="off">
                    <input type="hidden" name="outgoing" id="outgoing-date" value="{{ $data['outgoingDate'] }}">
                    {{ csrf_field() }}
                    <button type="button" onclick="submitUpdateWorkhourForm()">send</button>
                </form>
            </div>
        </div>
    </div>
@endsection
