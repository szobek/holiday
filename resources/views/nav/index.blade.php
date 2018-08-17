<nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-content"
            aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Brand -->
    <a class="navbar-brand" href="/">
        <section class="md-up">Céges Szabadságok <img src="/assets/logo_medium.png" height="40" alt="logo"></section>
        <section class="md-down"><img src="/assets/logo_medium.png" height="40" alt="logo"></section>
    </a>

    <!-- Links -->
    <div class="collapse navbar-collapse justify-content-center" id="nav-content">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="holidayDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Szabadságok
                </a>
                <div class="dropdown-menu" aria-labelledby="holidayDropdown">
                    <a class="nav-link" href="/list/{{date('Y')}}">Lista</a>
                    <a class="nav-link" href="/event/search">Keresés</a>
                </div>

            </li>
            @if(cp(9, \Illuminate\Support\Facades\Auth::user()->permission_list_ids))

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Felhasználók
                    </a>
                    <div class="dropdown-menu" aria-labelledby="usersDropdown">

                        <a class="nav-link" href="/users">Felhasználói lista</a>
                        @if(cp(8, \Illuminate\Support\Facades\Auth::user()->permission_list_ids))
                            <a class="nav-link" href="/user/new">Új felhasználó</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="nav-link" href="/workhours">Jelenléti</a>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link" href="/contacts">Névjegyzék</a>


                    </div>
                </li>

            @endif

            <li class="nav-item  dropdown">

                <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false" style="position: relative">
                    <span class="badge badge-danger" style="position: absolute; top: 0; left: 55px; display: none "></span>
                    Üzenetek
                </a>
                <div class="dropdown-menu" aria-labelledby="messageDropdown">

                    <a href="/messages" class="nav-link">Lista</a>
                    <a href="/messages/new" class="nav-link">Új üzenet</a>

                    <div class="dropdown-divider"></div>

                </div>
            </li>


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Beállítások
                </a>
                <div class="dropdown-menu" aria-labelledby="settingsDropdown">
                    @if(cp(10, Auth::user()->getPermissionIds()))
                    <a class="nav-link" href="/companies">Cégek</a>
                    @endif

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
