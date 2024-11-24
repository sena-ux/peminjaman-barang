<nav class="navbar navbar-expand-lg bg-dark text-white stiky-top col-12">
    <div class="container container-fluid col-xs-2 col-md-5">
        <a class="navbar-brand text-white fs-3" href="{{ route('home') }}">{{ config('app.name') }} | @yield('name_page', 'Register')</a>
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
                {{-- <ul class="navbar-nav ms-auto">
                    <li class="nav-item d-flex">
                        @if (Request::segment(1) == 'register')
                            <a class="nav-link active text-white" aria-current="page"
                                href="{{ Request::segment(2) == 'guru' ? route('register.siswa') : route('register.guru') }}">
                                {{ Request::segment(2) == 'guru' ? 'Siswa' : 'Guru' }}
                            </a>
                            <div class="dropdown">
                                <a class="nav-link text-light dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Login
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('login.siswa') }}">Siswa</a></li>
                                    <li><a class="dropdown-item" href="{{ route('login.guru') }}">Guru</a></li>
                                </ul>
                            </div>
                        @endif


                        @if (Request::segment(1) == 'login')
                            <a class="nav-link active text-white" aria-current="page"
                                href="{{ Request::segment(2) == 'guru' ? route('login.siswa') : route('login.guru') }}">
                                {{ Request::segment(2) == 'guru' ? 'Siswa' : 'Guru' }}
                            </a>
                            <div class="dropdown">
                                <a class="nav-link text-light dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Register
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('register.siswa') }}">Siswa</a></li>
                                    <li><a class="dropdown-item" href="{{ route('register.guru') }}">Guru</a></li>
                                </ul>
                            </div>
                        @endif
                    </li>
                </ul> --}}

            @endif
        </div>
    </div>
</nav>
