
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
                            <td><a href="{{ user_url($user->id) }}">{{$user->name}}</a></td>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach($user->company_list as $company)
                                        <li><a href="{{ company_url($company->id) }}">{{$company->short_name}}</a></li>
                                    @endforeach
                                </ul>

                            </td>
                            <td>{{$user->email}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>



@endsection
