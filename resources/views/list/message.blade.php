@if(session()->has('msg'))

    <div class="container">
        <div class="row">

            <div class="col">

                <div class="alert alert-{{session('msg')['type']}} alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{session('msg')['title']}}
                </div>

            </div>

        </div>
    </div>

@endif