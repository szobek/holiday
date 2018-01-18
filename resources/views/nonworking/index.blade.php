
@extends('master')

@section('sub_js')
    <script>
        $('#nonworkinglist').DataTable();

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

                <table class="table table-responsive" id="nonworkinglist">
                    <thead>
                    <tr>
                        <td colspan="4">
                            @foreach($years as $year)
                                <a class="btn btn-success btn-sm" href="/nonworking/{{ $year }}">{{ $year }}</a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>Év</th>
                        <th>Dátum</th>
                        <th>Név</th>
                        <th>Leírás</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($non_working as $item)
                        <tr class="@if($item->type == "holiday") table-danger @else table-success @endif">
                            <td>{{$item->year}}</td>
                            <td>{{$item->date}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->description}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col text-center"><a href="/nonworking/create" class="btn btn-primary"><i class="fa fa-plus fa-2x"></i></a></div>
        </div>
    </div>



@endsection
