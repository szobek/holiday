<div class="container">
    <script>
        window.user = {!! json_encode(\App\Http\Controllers\AttendanceController::getUserListByPermission()) !!}
        window.companies = {!! json_encode(\App\Http\Controllers\AttendanceController::getCompaniesListByPermission()) !!}
    </script>




    <div class="row justify-content-center " id="hidden-form" @if(!isset($show)) style="display: none" @endif>
        @if(!isset($show))
        <div class="col-12 text-right"><i class="fa fa-times fa-2x hidden-form" aria-hidden="true"></i></div>
        @endif
        <div class="col-12">
            <p>ide jön a privát data: <span data-private></span> </p>

            <form action="{{$action}}" method="post">

                <div class="row">
                    <div class="col">
                        <div class="input-group mb-2 mb-sm-0">
                            <div class="input-group-addon">Név</div>

                            <select name="company" id="company-selector" class="form-control">
                                <option value="">Válasszon</option>
                                @foreach(\App\Http\Controllers\AttendanceController::getCompaniesListByPermission() as $company)
                                    <option value="{{ $company->id }}">{{ $company->short_name }}</option>
                                @endforeach
                            </select>

                            <select name="name" id="" class="form-control"></select>
                        </div>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-2 mb-sm-0">
                            <div class="input-group-addon">Mettől</div>
                            <input type="text"
                                   class="datepicker form-control"
                                   data-date-format="yyyy-mm-dd"
                                   placeholder="Mettől"
                                   name="start"
                                   required
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-2 mb-sm-0">
                            <div class="input-group-addon">Meddig</div>
                            <input type="text"
                                   class="datepicker form-control"
                                   data-date-format="yyyy-mm-dd"
                                   placeholder="Meddig"
                                   name="end"
                                   required
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-2 mb-sm-0">
                            <div class="input-group-addon">Típus</div>
                            <select name="type"  id="" class="form-control">
                                <option value="1">Normál Szabadság</option>
                                <option value="2">Beteg Szabadság</option>
                                <option value="3">Egyéb</option>
                                <option value="4">Nem számított</option>
                            </select>
                        </div>
                    </div>

                </div>

                <br>

                <div class="row">

                    <div class="col">
                        <div class="input-group mb-2 mb-sm-0">
                            <div class="input-group-addon">Megjegyzés</div>
                            <input type="text" class="form-control" placeholder="Megjegyzés" name="description">
                        </div>

                    </div>

                    @if(isset($show) && $show )
                    <div class="col">
                        <div class="input-group mb-2 mb-sm-0">
                            <div class="input-group-addon">Státusz</div>
                            <select name="accepted" id="accepted">
                                <option value="0">Elutasítva</option>
                                <option value="1">Elfogadva</option>
                            </select>
                        </div>

                    </div>
                    @endif


                </div>

                <br>

                <div class="row">
                    <div class="col">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" name="id" value="{{ $event_data['id'] OR '' }}"/>
                        <button class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Mentés</button>
                    </div>
                </div>

            </form>




        </div>

    </div>



</div>

