@extends('master')



@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center ">
                    <a href="/workhours">Teljes lista</a>
                </h5>

                <a href="/workhours/new" class="h3" style="position: absolute;right: 60px;top: 0;"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>

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
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="start-year">Kezdő év</label>
                                <select name="year-start" id="start-year" class="form-control">
                                    @foreach(['2018','2019', '2020'] as $y)
                                        <option @if($y == $dates['ys']) selected @endif value="{{ $y }}">{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-3">
                                <label for="start-year">Kezdő hónap</label>
                                <select name="month-start" id="" class="form-control">
                                    @foreach(['01','02','03','04','05','06','07','08','09','10','11','12'] as $d)
                                        <option @if($d == $dates['ms']) selected @endif value="{{ $d }}">{{ $d }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="start-year">Záró év</label>
                                <select name="year-end" id="" class="form-control">
                                    @foreach(['2018','2019', '2020'] as $y)
                                        <option @if($y == $dates['ye']) selected @endif value="{{ $y }}">{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="start-year">Záró hónap</label>
                                <select name="month-end" id="" class="form-control">
                                    @foreach(['01','02','03','04','05','06','07','08','09','10','11','12'] as $d)
                                        <option @if($d == $dates['me']) selected @endif value="{{ $d }}">{{ $d }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <button class="btn btn-success" id="searchRange">Keres</button>
                            </div>
                        </div>




                    </div>

                </div>



            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
            {{--http://www.chartjs.org/docs/latest/charts/line.html--}}
            {{--<div class="col-md-12">
                <canvas id="myChart" width="400" height="400"></canvas>
                <script>
                    var ctx = document.getElementById("myChart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                            datasets: [{
                                label: '# of Votes',
                                data: [{
                                    x: 10,
                                    y: 20
                                }, {
                                    x: 15,
                                    y: 10
                                }],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255,99,132,1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    });
                </script>
            </div>--}}

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
                                <a class="btn btn-success" href="/workhours/edit/{{$data['id']}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <button class="btn btn-danger" onclick="confirmDelete({{$data['id']}})" ><i class="fa fa-ban" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>




        </div>
    </div>



@endsection
