@extends('master')

@section('content')

@include('list.message')

<div class="container">

    <script>
        window.events = {!! json_encode($events) !!};
    </script>



    <div class="row">

        <table class="table table-bordered table-striped" id="holiday">
            <thead>
            <tr >
                <td colspan="6">
                    <a href="/list/2017" class="btn btn-success btn-sm">2017</a>
                    <a href="/list/2018" class="btn btn-success btn-sm">2018</a>
                    <a href="/list/2019" class="btn btn-success btn-sm">2019</a>
                    <a href="/list/2020" class="btn btn-success btn-sm">2020</a>
                </td>
            </tr>
            <tr>
                <th>Mettől</th>
                <th>Meddig</th>
                <th>Név</th>
                <th>Cég</th>
                <th>Megjegyzés</th>
                <th>Sorszám</th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event['start']->format('Y-m-d') }}</td>
                    <td>{{ $event['end']->format('Y-m-d') }}</td>

                    <td><a href="{{ user_url($event['user_id'])}}">{{ $event['name'] }}</a></td>

                    <td><a href="{{ company_url($event['company_id']) }}">{{ $event['company'] }}</a></td>
                    <td>{{ $event['description'] }} - {{ $event['type'] }} </td>
                    <td>
                        <a href="/update/{{ $event['id'] }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>

                        <form action="/delete" method="post" onsubmit="return confirm('valóban törli?')" style="display: inline-block">
                            <input type="hidden" name="id" value="{{$event['id']}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-danger btn-sm">
                                <i class="fa fa-times"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <div class="row justify-content-center">

        <div class="col">

            <p class="text-center">
                <a href="#" class="btn btn-primary btn-lg active hidden-form" role="button" aria-pressed="true">Új felvitel</a>
            </p>

        </div>

    </div>


</div>

@include('list/form', ['action' => '/create'])
@endsection