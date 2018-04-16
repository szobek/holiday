@if(($event['user_id'] === \Illuminate\Support\Facades\Auth::user()->id && cp(13,session('permissions')) ) || cp(14,session('permissions'))) {{--ha a sajátja és törölheti a sajátját--}}
<form action="/event/delete" method="post" onsubmit="return confirm('valóban törli?')"
      style="display: inline-block">
    <input type="hidden" name="id" value="{{$event['id']}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button class="btn btn-danger btn-sm">
        <i class="fa fa-times"></i>
    </button>
</form>
@endif