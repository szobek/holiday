@extends('master')


@section('title')

@endsection

@section('description')

@endsection

@section('content')

    <script>
        window.user = {!! json_encode(\App\Http\Controllers\AttendanceController::getUserListByPermission()) !!}
    </script>

    <div class="container">
        <div class="row">
            <div class="col-3">

            </div>
            <div class="col-6">
                <form action="/event/search" method="post">
                    <label for="company-selector">Cég választás</label>
                    <select name="company" id="company-selector" class="form-control">
                        <option value="">Válasszon</option>
                        @foreach(\App\Http\Controllers\AttendanceController::getCompaniesListByPermission() as $company)
                            <option value="{{ $company->id }}">{{ $company->short_name }}</option>
                        @endforeach
                    </select>

                    <label for="name-selector">Felhasználó</label>
                    <select name="name" id="name-selector" class="form-control">
                        <option value="">Válasszon</option>
                        @foreach(\App\Http\Controllers\AttendanceController::getUserListByPermission() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    {{ csrf_field() }}

                    <button class="btn btn-success">Keresés</button>



                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @foreach($events as $event)
                    {{ dd2($event)  }}
                @endforeach
            </div>
        </div>
    </div>



@endsection
