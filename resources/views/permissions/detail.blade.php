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
                        <h4 class="h4">{{ $permission['name'] }}</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{Request::url()}}" method="post">
                            <div class="form-group">
                                <label for="name">Név</label>
                                <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        id="name"
                                        placeholder="Név"
                                        value="{{ $permission->name }}"
                                >

                            </div>

                            <div class="form-group">
                                <label for="description">Leírás</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        name="description"
                                        id="description"
                                        placeholder="Leírás"
                                        value="{{ $permission->description }}"
                                />
                            </div>
                            <input type="hidden" name="{{ $permission->id }}">
                            {{ csrf_field() }}
                            <button class="btn btn-success">Mentés</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
