@extends('master')



@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center ">
                    <a href="/workhours">Teljes lista</a>
                </h5>

                <p class="text-center">Szűrés erre: {{ $search }}</p>


            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Dátum szerinti keresés
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12  collapse" id="collapseExample">
                        <div class="form-group col-md-3">
                            <label for="start-year">Kezdő év</label>
                            <select name="year-start" id="start-year" class="form-control">
                                @foreach(['2018','2019', '2020'] as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="start-year">Kezdő hónap</label>
                            <select name="month-start" id="" class="form-control">
                                @foreach(['01','02','03','04','05','06','07','08','09','10','11','12'] as $d)
                                    <option value="{{ $d }}">{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="start-year">Záró év</label>
                            <select name="year-end" id="" class="form-control">
                                @foreach(['2018','2019', '2020'] as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="start-year">Záró hónap</label>
                            <select name="month-end" id="" class="form-control">
                                @foreach(['01','02','03','04','05','06','07','08','09','10','11','12'] as $d)
                                    <option value="{{ $d }}">{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <button class="btn btn-success" id="searchRange">Keres</button>
                        </div>
                    </div>

                </div>



            </div>

            <div class="col-md-12">


                <table class="table table-bordered table-striped" id="workhours">
                    <thead>
                    <tr>
                        <th>Felhasználó</th>
                        <th>Nap</th>
                        <th>Érkezés</th>
                        <th>Távozás</th>
                        <th>Szerkesztés</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($wh as $data)
                        <tr>
                            <td>
                                <a href="/workhours/single-user/{{ $data['user_id'] }}">{{ $data['user']->name or '' }}</a>
                            </td>
                            <td><a href="/workhours/single-day/{{ $data['day'] }}">{{ $data['day'] }}</a></td>
                            <td>{{ $data['incoming'] }}</td>
                            <td>{{ $data['outgoing'] }}</td>
                            <td>
                                <a href="/workhours/edit/{{$data['id']}}">szerk</a>
                                <button class="btn btn-danger" onclick="confirmDelete({{$data['id']}})" >törlés</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>



@endsection
