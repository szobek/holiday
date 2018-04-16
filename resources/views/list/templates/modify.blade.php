@if(($event['user_id'] === \Illuminate\Support\Facades\Auth::user()->id && cp(16,session('permissions')) ) || cp(15,session('permissions')))
    <a href="/event/update/{{ $event['id'] }}" class="btn btn-primary btn-sm">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
    </a>
@endif