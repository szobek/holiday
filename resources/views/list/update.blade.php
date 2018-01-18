@extends('master')

@section('content')


    @include('list.form', ['show' => true, 'action' => '/update'])



@endsection

@section('sub_js')
    <script>
        function loadModifyData(event) {
            "use strict";
            window.event = event;

            $('#company-selector').val(event.company_id).prop('disabled', true);
            $("[name='name']").append(`<option>${event.name}</option>`).prop('disabled', true);

            $("[name='start']").datepicker('update', event.start.date.slice(0,10));
            $("[name='end']").datepicker('update', event.end.date.slice(0,10));


            $("[name='type']").val(event.type);
            $("[name='description']").val(event.description);

            $("[name='type']").val(event.type_id);


        }

        loadModifyData({!! json_encode($event_data) !!})
    </script>
@endsection