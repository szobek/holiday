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
            <div class="col-12">
                <ul class="list-unstyled">
                    @foreach($conversation as $conversation)
                        <li>
                            <a href="/message/{{$conversation->conversationData->id}}">
                                {{$conversation->conversationData->receiver['name']}} - {{$conversation->conversationData->title}}
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>

@endsection
