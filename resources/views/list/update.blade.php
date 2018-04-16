@extends('master')

@section('content')


    @include('list/form', ['show' => true, 'action' => '/event/update'])



@endsection

@section('sub_js')
    <script>
        function loadModifyData(event) {
            "use strict";
            window.event = event;

            $('#company-selector').val(event.company_id);
            $("[name='name']").append(`<option>${event.name}</option>`);

            $("[name='start']").datepicker('update', event.start.date.slice(0,10));
            $("[name='end']").datepicker('update', event.end.date.slice(0,10));

            $("[name='description']").val(event.description);

            $("[name='type']").val(event.type_id);
            $("[name='accepted']").val(event.accepted);
            $('span[data-private]').html(event.private_user);
            // console.log(event)


        }

        loadModifyData({!! json_encode($event_data) !!})
    </script>
@endsection