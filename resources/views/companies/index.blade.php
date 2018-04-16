
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
                        <th>Rövid név</th>
                        <th>Cím</th>
                        <th>Adószám</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($companies as $company)
                        <tr>
                            <td>
                                @if(cp(12, Auth::user()->getPermissionIds()))
                                    <a href="/companies/profile/{{ $company->id }}">{{$company->short_name}}</a>
                                @else
                                    {{$company->short_name}}
                                @endif
                            </td>
                            <td>{{$company->address}}</td>
                            <td>{{$company->tax}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row ">
            <div class="col text-center">
                <a href="/companies/new" class="btn btn-primary btn-lg">Új cég</a>
            </div>




        </div>
    </div>



@endsection
