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
            <div class="col-12 mt-3">
                <h3>Üzenetek</h3>
                <hr>


                <ul class="list-group">
                    @foreach($conversation as $conversation)
                        <a href="/message/{{$conversation->conversationData->id}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            {{$conversation->conversationData->receiver['name']}} - {{$conversation->conversationData->title}}
                            <span class="badge badge-primary badge-pill">{{ count($conversation->messages) }}</span>
                        </a>

                    @endforeach

                </ul>

            </div>
        </div>
    </div>

@endsection
