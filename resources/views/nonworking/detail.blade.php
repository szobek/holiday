@extends('master')

@section('sub_js')
    <script>

    </script>
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
                <h1>Új ünnepnap</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col">

                <form action="{{Request::url()}}" method="post">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="name">Neve</label>
                        <input type="text" name="name" id="name" class="form-control"  value="@if(isset($nwd) && isset($nwd->name)) {{$nwd->name}} @endif" autocomplete="off"/>
                        {{--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>--}}
                    </div>
                    <div class="form-group">
                        <label for="year">Mikor (év)</label>
                        <select class="form-control" name="year" id="year"  value="@if(isset($nwd) && isset($nwd->year)) {{$nwd->year}} @endif">
                            @foreach($years as $year)
                            <option value="{{ $year }}" @if(Date('Y')==$year) selected @endif>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check">
                        <label for="date">Dátum</label>
                        <input class="form-control datepicker " type="text" name="date" data-date-format="yyyy-mm-dd" id="date" value="@if(isset($nwd) && isset($nwd->date)) {{$nwd->date}} @endif" autocomplete="off"/>
                    </div>
                    <div class="form-check">
                        <label for="description">Leírás</label>
                        <input class="form-control" type="text" name="description" id="description" value="@if(isset($nwd) && isset($nwd->description)) {{$nwd->description}} @endif" autocomplete="off"/>
                    </div>
                    <div class="form-check">
                        <label for="type">Típus</label>
                        <select class="form-control" name="type" id="type"  value="@if(isset($nwd) && isset($nwd->type)) {{$nwd->type}} @endif">
                            <option value="holiday">Szabadság</option>
                            <option value="work">Munkanap</option>
                        </select>
                    </div>


                    <input type="hidden" name="id"  value="@if(isset($nwd) && isset($nwd->id)) {{$nwd->id}} @endif">
                    <button type="submit" class="btn btn-primary">Mentés</button>
                </form>
            </div>
        </div>
    </div>

@endsection
