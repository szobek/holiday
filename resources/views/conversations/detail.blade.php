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
            <div class="col-6 offset-3">
                <p>itt lesz a megtekintése egynek</p>
                <div class="card">
                    <div class="card-header">
                        {{ $conversation->conversationData->created }} | {{ $conversation->conversationData->sender['name'] }} <-> {{ $conversation->conversationData->receiver['name'] }}

                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @foreach($conversation->messages as $message)
                                <li class="@if($message->by === 'sender')text-left @else text-right @endif"><small>{{ $message->date }}</small> {{ $message->content }} </li>
                            @endforeach

                        </ul>
                    </div>
                    <div class="card-footer">
                        <form action="{{($conversation->conversationData->id === 0) ? '/messages/new' :  '/messages/answer' }}" name="chatForm" method="post">
                            @if($conversation->conversationData->id === 0)

                                <div class="form-group">
                                    <label for="users">Felhasználók</label>
                                    <select name="receiver" id="users" class="form-control">
                                        @foreach($users as $user)
                                            @if($user['id'] != \Illuminate\Support\Facades\Auth::user()->id)
                                            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="title">Tárgy</label>
                                    <input type="text" id="title" name="title" class="form-control" autocomplete="off"/>
                                </div>





                            @endif
                            <textarea class="form-control mb-5" name="msgContent" id="" cols="30" rows="10"></textarea>
                            <input type="hidden" name="cid" value="{{ $conversation->conversationData->id}}">
                            {{ csrf_field() }}
                            <button id="sendMessage" class="btn btn-success ">Küldés</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
