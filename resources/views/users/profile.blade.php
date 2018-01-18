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
            <div class="col-6">

                <form method="post" action="{{ $action }}">
                    <div class="form-group">
                        <label for="name">Név</label>
                        <input type="text" value="{{ $user->name }}" class="form-control" name="name" id="name"
                               placeholder="Név" @if(!cp(4,$pl) && cp(3,$pl)) disabled @endif>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" value="{{ $user->email }}" class="form-control" name="email" id="email"
                               placeholder="email" @if(!cp(4,$pl) && cp(3,$pl)) disabled @endif>
                    </div>


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
                                            @if(!cp(4,$pl) && cp(3,$pl)) disabled @endif
                                    >
                                    <label for="companies-{{$company['id']}}">{{$company['short_name']}}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div>

                    </div>

                    <div class="form-group">
                        <label for="holidays">Szabadnapok</label>
                        <input type="number" max="99" value="{{ $user->holidays }}" class="form-control" name="holidays"
                               id="holidays" placeholder="Szabadnapok" @if(!cp(4,$pl) && cp(3,$pl)) disabled @endif>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Telefon</label>
                        <input type="text" value="{{ $user->telephone }}" class="form-control" name="telephone"
                               id="telephone" placeholder="Telefonszám" @if(!cp(4,$pl) && cp(3,$pl)) disabled @endif>
                    </div>


                    {{--ha új reg--}}
                    @if(isset($psw))
                        @include('users.new_reg_psw')
                    @endif

                    @if(\Illuminate\Support\Facades\Auth::user()->id == $user->id)
                        @include('users.mypassword')
                    @endif

                    @if(cp(4,$pl))
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    @endif



                </form>


            </div>
            <div class="col-6 left-border">
                @if(isset($delete))

                    <ul class="list-unstyled">


                        {{--{{ dd($pl) }}--}}
{{--                        {{ dd(cp(4,$pl)) }}--}}

                        @foreach($user->company_list as $company)
                            @if(cp(4,$pl))
                            <li class="pdf-list">
                                <a href="/pdf/{{ date('Y') }}/{{ date('m') }}/{{ $user->id }}/{{ $company->id }}"
                                   class="btn btn-success"
                                   target="_blank">{{ $company->short_name }}pdf mutatása (aktuális)</a>
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
                        @if(cp(4,$pl))
                        <a href="/user/delete/{{ $user->id }}" class="btn btn-danger"
                           onclick="return confirm('Valóban törli?')">Törlés</a>
                        @endif
                    </div>


                @endif
            </div>
        </div>

    </div>

@endsection
