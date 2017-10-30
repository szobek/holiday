@extends('master')

@section('sub_js')
@endsection

@section('sub_css')
@endsection

@section('title')
@endsection

@section('content')

    <div class="container">

        @if(isset($errors))
            @foreach ($errors->all() as $item => $message)
                {{$item}}{{$message}}
            @endforeach
        @endif


        <div class="row">
            <div class="col">

                <form method="post" action="{{ $action }}">
                    <div class="form-group">
                        <label for="name">Név</label>
                        <input type="text" value="{{ $user->name }}" class="form-control" name="name" id="name" placeholder="Név">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" value="{{ $user->email }}" class="form-control" name="email" id="email" placeholder="email">
                    </div>
                    <div class="form-group">
                        <label for="company">Cég</label>
                        <select name="company" class="form-control" id="">
                            @foreach($companies as $company)
                                <option class="form-control"
                                        @if(isset($user->company_data) && $user->company_data->id == $company->id) selected @endif
                                    value="{{ $company->id }}">
                                    {{ $company->short_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if(isset($psw))
                    <div class="form-group">
                        <label for="email">Jelszó</label>
                        <input type="password" class="form-control" name="password" id="psw" placeholder="Jelszó">
                    </div>
                    <div class="form-group">
                        <label for="email">Jelszó újra</label>
                        <input type="password" class="form-control" name="password2" id="psw2" placeholder="Jelszó újra">
                    </div>
                    @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <button type="submit" class="btn btn-primary">Submit</button>


                </form>
                <hr>

                <a href="/pdf/{{ date('Y') }}/{{ date('m') }}/{{ $user->id }}" class="btn btn-success">pdf mutatása (aktuális)</a>
            </div>
        </div>

    </div>

@endsection
