@if($event['user_id'] === \Illuminate\Support\Facades\Auth::user()->id || cp(17,session('permissions')) )

<a href="/event/view/{{ $event['id'] }}" class="btn btn-success btn-sm">
    <i class="fa fa-eye"></i>
</a>

@endif