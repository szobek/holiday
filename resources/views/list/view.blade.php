@extends('master')

@section('sub_js')
@endsection

@section('sub_css')
@endsection

@section('title')
    Event view
@endsection

@section('description')

@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <section class="card-header">
                        {{ $event['name'] }}
                    </section>
                    <section class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Kezdet</th>
                                <th>Vég</th>
                                <th>Cég</th>
                                <th>Megjegyzés</th>
                                <th>Típus</th>
                                <th>Elfogadva</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($event['start'])->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($event['end'])->format('Y-m-d') }}</td>
                                <td>{{ $event['company'] }}</td>
                                <td>{{ $event['description'] }}</td>
                                <td>{{ $event['type'] }}</td>
                                <td>@include('list/templates/accepted')</td>
                            </tr>
                            </tbody>
                        </table>
                    </section>
                    <section class="card-footer">
                        @include('list/templates/modify')
                        @include('list/templates/delete')
                    </section>
                </div>

{{--
                <pre>
                    {{ dd2($event) }}
                </pre>
--}}
            </div>
        </div>
    </div>

@endsection
