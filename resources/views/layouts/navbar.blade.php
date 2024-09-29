<nav class="navbar navbar-expand-lg bg-primary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">SAPAs | @yield('name_page', "Register")</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @if (Auth::user())
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Pengaduan</a>
                    </li>
                </ul>
            @else
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        @if (Request::segment(1) == 'register')
                            <a class="nav-link active" aria-current="page"
                                href="{{ route('login') }}">
                                @yield('redirect', "Login")
                            </a>
                        @else
                            <a class="nav-link active" aria-current="page"
                                href="{{ route('register') }}">
                                @yield('redirect', "Login")
                            </a>
                        @endif
                    </li>
                </ul>

            @endif
        </div>
    </div>
</nav>
