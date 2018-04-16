@extends('master')

@section('content')

    @include('list.message')

    <div class="container">

        <script>
            window.events = {!! json_encode($events) !!};
        </script>

        <div class="row justify-content-center">

            <div class="col">

                <p class="text-center">
                    <a href="#" class="btn btn-primary btn-lg active hidden-form" role="button" aria-pressed="true">Új
                        felvitel</a>
                </p>

            </div>

        </div>

        <div class="row" id="holiday-table">

            <table class="table table-bordered table-striped" id="holiday">
                <thead>
                <tr>
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
                    <th>Művelet</th>
                </tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>
                            @include('list/templates/accepted')
                            {{ $event['start']->format('Y-m-d') }}
                        </td>

                        <td>
                            {{ $event['end']->format('Y-m-d') }}
                        </td>

                        <td>
                            {{--{{ $event['private_user'] }}--}}
                            @if(cp(3, session('permissions')))
                                <a href="{{ user_url($event['user_id'])}}">{{ $event['name'] }}</a>
                            @else

                                {{ $event['name'] }}
                            @endif
                        </td>

                        <td>
                            @if(cp(12,session('permissions')))
                                <a href="{{ company_url($event['company_id']) }}">{{ $event['company'] }}</a>
                            @else
                                {{ $event['company'] }}
                            @endif
                        </td>

                        <td>
                            {{ $event['description'] }} - {{ $event['type'] }}
                        </td>

                        <td>

                            @include('list/templates/modify')
                            @include('list/templates/delete')
                            @include('list/templates/view', ['id' => $event['id']])
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>




    </div>

    @include('list/form', ['action' => '/create'])
@endsection