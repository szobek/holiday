
@extends('master')

@section('sub_js')
    <script>
        $('#userlist').DataTable();

    </script>
@endsection

@section('sub_css')

@endsection

@section('title')

@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">

                <table class="table" id="userlist">
                    <thead>
                        <tr>
                            <th>Név</th>
                            <th>Cég</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td><a href="/user/profile/{{ $user->id }}">{{$user->name}}</a></td>
                            <td>{{$user->company_data->short_name}}</td>
                            <td>{{$user->email}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col text-center">
            <a href="/user/new" class="btn btn-primary btn-lg">Új felhasználó</a>
        </div>
    </div>



@endsection
