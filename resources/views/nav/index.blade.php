<nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-content"
            aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Brand -->
    <a class="navbar-brand" href="/">
        <section class="md-up">Céges Szabadságok</section>
        <section class="md-down">CSZ</section>
    </a>

    <!-- Links -->
    <div class="collapse navbar-collapse justify-content-center" id="nav-content">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/list/{{date('Y')}}">Szabadságok</a>
            </li>
            @if(cp(9, \Illuminate\Support\Facades\Auth::user()->permission_list_ids))

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Felhasználók
                    </a>
                    <div class="dropdown-menu" aria-labelledby="usersDropdown">

                        <a class="nav-link" href="/users">Felhasználói lista</a>
                        <div class="dropdown-divider"></div>

                    </div>
                </li>

            @endif


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Beállítások
                </a>
                <div class="dropdown-menu" aria-labelledby="settingsDropdown">

                    <a class="nav-link" href="/companies">Cégek</a>
                    <a class="nav-link" href="/permissions">Jogok</a>
                    <a class="nav-link" href="/nonworking">Ünnepnapok</a>
                    <div class="dropdown-divider"></div>

                </div>
            </li>


            @if(\Illuminate\Support\Facades\Auth::check())

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ \Illuminate\Support\Facades\Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item"
                           href="/user/profile/{{ \Illuminate\Support\Facades\Auth::user()->id }}">Profil</a>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </a>
                        {{--<a class="dropdown-item" href="#">Another action</a>--}}

                        {{--<a class="dropdown-item" href="#">Something else here</a>--}}
                    </div>
                </li>

            @else
                <li>
                    <a class="nav-link" href="/login">Bejelentkezés</a>
                </li>
            @endif

        </ul>

    </div>
</nav>
