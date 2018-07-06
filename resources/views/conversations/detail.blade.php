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

    <div class="container message-detail-container">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3 mt-3">
                <div class="row">
                    <div class="col-6">
                        <h3>
                            @if($conversation->conversationData->sender['id'] === \Illuminate\Support\Facades\Auth::user()->id)
                                {{ $conversation->conversationData->receiver['name'] }}
                            @else
                                {{ $conversation->conversationData->sender['name'] }}
                            @endif
                        </h3>
                        <h6>{{ $conversation->conversationData->title or '' }} </h6>
                    </div>
                    <div class="col-6 text-right"><small style="font-size: 0.7rem;">{{ $conversation->conversationData->created }}</small></div>
                </div>


                <hr>
                <div class="card ">

                    <div class="card-body">
                        @if($conversation->conversationData->id != 0)
                        <div class="message-list pb-3 mb-3">
                            <ul class="list-unstyled">
                                @foreach($conversation->messages as $message)
                                    <li class="@if($message->by === 'sender')text-left @else text-right @endif item">
                                        <p>
                                            <small>{{ $message->date }}</small>
                                            <br>
                                            {{ $message->content }}
                                        </p>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        @endif

                        <section class="message-send">
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
                        </section>

                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
