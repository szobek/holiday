<nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-content" aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Brand -->
    <a class="navbar-brand" href="/">Céges Szabadságok</a>

    <!-- Links -->
    <div class="collapse navbar-collapse justify-content-center" id="nav-content">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/list/{{date('Y')}}">Szabadságok</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/users">Felhasználók</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/companies">Cégek</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/permissions">Jogok</a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="/nonworking">Ünnepnapok</a>
            </li>
            @if(\Illuminate\Support\Facades\Auth::check())
            <li>
                <a class="nav-link"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </a>
            </li>
            @else
            <li>
                <a class="nav-link" href="/login">Bejelentkezés</a>
            </li>
            @endif

        </ul>

    </div>
</nav>
