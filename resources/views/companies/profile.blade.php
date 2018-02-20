@extends('master')

@section('sub_js')
@endsection

@section('sub_css')
@endsection

@section('title')
@endsection

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-6">
                <h4>Adatok</h4>
                <form method="post" action="{{ $action }}">
                    <div class="form-group">
                        <label for="short_name">Rövid név</label>
                        <input type="text" value="{{ $company->short_name }}" class="form-control" name="short_name"
                               id="short_name" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Név</label>
                        <input type="text" value="{{ $company->name }}" class="form-control" name="name" id="name"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="address">Cím</label>
                        <input type="text" value="{{ $company->address }}" class="form-control" name="address"
                               id="address" required>
                    </div>
                    <div class="form-group">
                        <label for="tax">Adószám</label>
                        <input type="text" value="{{ $company->tax }}" class="form-control" name="tax" id="tax"
                               required>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $company->id }}">
                    <button type="submit" class="btn btn-primary">Mentés</button>
                </form>
            </div>

            <div class="col-6">
                <h4>Felhasználók</h4>
                <ul class="list-unstyled">

                    @if(isset($company->users))
                        @foreach($company->users as $user)
                            <li>
                                <a href="/user/profile/{{$user->id}}">{{ $user->name }}</a>
                            </li>

                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

    </div>

@endsection
