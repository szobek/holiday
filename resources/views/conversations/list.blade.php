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

    <div class="lds-dual-ring"></div>
    <script>
        window.me = {!! json_encode(\Illuminate\Support\Facades\Auth::user()->id)!!};

    </script>

    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 mb-5">
                <h3>Üzenetek</h3>
                <hr>
                <ul class="list-group" id="conversation-list"></ul>

            </div>
        </div>
    </div>

@endsection
