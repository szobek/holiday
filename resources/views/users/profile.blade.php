@extends('master')

@section('title')
    {{ $user->name OR ''}} felhasználói adatlap
@endsection

@section('content')


    <div class="container profile-container">

        @if(isset($errors))
            @foreach ($errors->all() as $item => $message)
                {{$item}}{{$message}}
            @endforeach
        @endif

        <div class="row">
            <div class="col-md-6">

                <form method="post" action="{{ $action }}">

                    {{--név + email--}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Név</label>
                            <input type="text" value="{{ $user->name }}" class="form-control" name="name" id="name"
                                   placeholder="Név" @if(!perm_edit_input($user->id)) disabled @endif>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email address</label>
                            <input type="email" value="{{ $user->email }}" class="form-control" name="email" id="email"
                                   placeholder="email" @if(!perm_edit_input($user->id)) disabled @endif>
                        </div>
                    </div>



                    {{--telefon + szabadnap--}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="holidays">Szabadnapok</label>
                            <input type="number" max="99" value="{{ $user->holidays }}" class="form-control" name="holidays"
                                   id="holidays" placeholder="Szabadnapok" @if(!perm_edit_input($user->id)) disabled @endif>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telephone">Telefon</label>
                            <input type="text" value="{{ $user->telephone }}" class="form-control" name="telephone"
                                   id="telephone" placeholder="Telefonszám" @if(!perm_edit_input($user->id)) disabled @endif>
                        </div>

                        <div class="form-group col-md-12">
                            <p>Kivett szabadnapok: {{ $allHoliday or '' }}</p>
                            @if(strlen($alert) > 0)
                                <p class="alert-danger">{{ $alert }}</p>
                            @endif
                        </div>
                    </div>

                    {{--cégek--}}
                    <div class="form-group">
                        <p>Cégek</p>
                        <ul class="list-unstyled">


                            @foreach($companies as $company)
                                <li>
                                    <input
                                            class="styled-checkbox"
                                            id="companies-{{$company['id']}}"
                                            type="checkbox"
                                            value="{{$company['id']}}"
                                            name="companies[]"
                                            @if(in_array($company['id'], $companies_list->pluck('id')->toArray())) checked @endif
                                            @if(!perm_edit_input($user->id)) disabled @endif
                                    >
                                    <label for="companies-{{$company['id']}}">{{$company['short_name']}}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>



                    {{--ha új reg--}}
                    @if(isset($psw))
                        @include('users/new_reg_psw')
                    @endif

                    @if(\Illuminate\Support\Facades\Auth::user()->id == $user->id)
                        @include('users.mypassword')
                    @endif

                    @if(cp(4,$pl) || $action === '/user/new' || Auth::user()->id === $user->id)
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-primary">Mentés</button>
                    @endif



                </form>


            </div>
            <div class="col-md-6 left-border">
                @if(isset($delete))

                    <ul class="list-unstyled">

                        @foreach($user->company_list as $company)
                            @if(cp(4,$pl))
                            <li class="pdf-list">
                                <a href="/pdf/{{ date('Y') }}/{{ date('m') }}/{{ $user->id }}/{{ $company->id }}"
                                   class="btn btn-success"
                                   target="_blank">
                                    {{ $company->short_name }}pdf mutatása (aktuális)
                                </a>
                            </li>
                            @endif
                        @endforeach
                    </ul>


                    <div class="form-group">
                        @if(cp(5,$pl))
                        <a class="btn btn-primary" href="/permissions/contact_user/{{$user->id}}">Jogok szerkesztése</a>
                        @endif
                    </div>

                    <hr>

                    <div class="form-group">
                        @if(cp(11,$pl))
                        <a href="/user/delete/{{ $user->id }}" class="btn btn-danger"
                           onclick="return confirm('Valóban törli?')">Törlés</a>
                        @endif
                    </div>


                @endif





            </div>

        </div>

        <div class="row holiday-container">
            <div class="col">
                <hr>
            </div>
            <div class="col-md-12">
                <a class="btn btn-primary" data-toggle="collapse" href="#userHolidays" aria-expanded="false" aria-controls="userHolidays">
                    Szabadságok
                </a>
            </div>
            <div class="col-md-12">
                <div class="collapse" id="userHolidays">
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
                            <th>Művelet</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($userEvents))
                            @foreach($userEvents as $event)
                            <tr>
                                <td>{{ $event['start']->format('Y-m-d') }}</td>
                                <td>{{ $event['end']->format('Y-m-d') }}</td>

                                <td> {{ $event['name'] }} </td>

                                <td>
                                    @if(cp(12,$pl))
                                        <a href="{{ company_url($event['company_id']) }}">{{ $event['company'] }}</a>
                                    @else
                                        {{ $event['company'] }}
                                    @endif
                                </td>
                                <td>{{ $event['description'] }} - {{ $event['type'] }} </td>
                                <td>
                                    @include('list/templates/modify')
                                    @include('list/templates/delete')
                                    @include('list/templates/view')
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

@endsection
