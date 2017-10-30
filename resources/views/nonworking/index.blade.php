
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

                <table class="table" id="nonworkinglist">
                    <thead>
                    <tr>
                        <th>Év</th>
                        <th>Dátum</th>
                        <th>Név</th>
                        <th>Leírás</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($non_working as $item)
                        <tr>
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
    </div>



@endsection
