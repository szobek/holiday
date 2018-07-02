@extends('master')



@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">


                <table class="table table-bordered table-striped" id="workhours">
                    <thead>
                    <tr>
                        <th>Felhasználó</th>
                        <th>Nap</th>
                        <th>Érkezés</th>
                        <th>Távozás</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($wh as $data)
                            <tr>
                                <td>{{ $data['user']->name or '' }}</td>
                                <td>{{ $data['day'] }}</td>
                                <td>{{ $data['incoming'] }}</td>
                                <td>{{ $data['outgoing'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>



@endsection
