@extends('master')

@section('sub_js')
@endsection

@section('sub_css')
@endsection

@section('title')

@endsection

@section('description')

@endsection

@section('content')

    <div class="lds-dual-ring"></div>

    <script>
        window.me = {!! json_encode(\Illuminate\Support\Facades\Auth::user()->id)!!};

    </script>
    <div class="container message-detail-container">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3 mt-3">
                <div class="row">
                    <div class="col-6">
                        <h3 id="contact"></h3>
                        <h6></h6>
                    </div>
                    <div class="col-6 text-right">
                        <small style="font-size: 0.7rem;" id="conversation-date"></small>
                    </div>
                </div>


                <hr>
                <div class="card ">

                    <div class="card-body">


                        <div class="message-list pb-3 mb-3" id="message-list-container">
                            <ul class="list-unstyled" id="message-list"></ul>
                        </div>

                        <section class="message-send">
                            <form name="chat-form">
                                <div class="form-group" id="user-list">
                                    <label for="users">Felhasználók</label>
                                    <select name="receiver" id="users" class="form-control"></select>
                                </div>

                                <div class="form-group" id="title-container">
                                    <label for="title">Tárgy</label>
                                    <input type="text" id="title" name="title" class="form-control" autocomplete="off"/>
                                </div>


                                <input type="hidden" name="cid">
                                <textarea class="form-control mb-5" name="msgContent" id="" cols="30"
                                          rows="10"></textarea>
                                <div class="form-group">
                                    <input type="checkbox" name="autoscroll" id="autoscroll" >
                                    <label for="autoscroll">Autoscroll</label>
                                </div>
                                <button type="button" class="btn btn-success" id="send-message">Küldés</button>
                            </form>

                        </section>

                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
