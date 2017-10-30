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
            <tr>
                <th>Mettől</th>
                <th>Meddig</th>
                <th>Sorszám</th>
                <th>Név</th>

                <th>Cég</th>
                <th>Megjegyzés</th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event['start']->format('Y-m-d') }}</td>
                    <td>{{ $event['end']->format('Y-m-d') }}</td>
                    <td>
                        <a href="/update/{{ $event['id'] }}">{{ $event['id'] }}</a>
                        <form action="/delete" method="post">
                            <input type="hidden" name="id" value="{{$event['id']}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-danger btn-sm">
                                <i class="fa fa-times"></i>
                            </button>
                        </form>
                    </td>
                    <td>{{ $event['name'] }}</td>

                    <td>{{ $event['company'] }}</td>
                    <td>{{ $event['description'] }} - {{ $event['type'] }} </td>
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

@include('list.form', ['action' => '/create'])
@endsection