{{-- Mode Mobile --}}

<aside class="main-footer col-12 sidebar-dark-primary p-2" id="navbarMobile">
    <div id="collapseGroup">
        <!-- Collapse 1 -->
        <div class="subnemuCollapse">
            <div class="collapse collapse-horizontal" id="collapseWidthExample" data-bs-parent="#collapseGroup">
                <div class="card card-body" style="width: 300px;">
                    This is some placeholder content for a horizontal collapse. It's hidden by default and shown when
                    triggered.
                </div>
            </div>
        </div>

        <div class="subnemuCollapse">
            <div class="collapse collapse-horizontal" id="pengaduan" data-bs-parent="#collapseGroup">
                <div class="card card-body" style="width: 300px;">
                    <div class="list-group">
                        <a href="{{ route('umum.index') }}" class="list-group-item list-group-item-action {{ Request::segment(2) == 'umum' ? 'bg-primary' : '' }}" aria-current="true">
                            <i class="far fa-circle nav-icon"></i>
                            Pengaduan Umum
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="far fa-circle nav-icon"></i>
                            Kebutuhan Ruangan
                        </a>
                        <a href="{{ route('barangrk.index') }}" class="list-group-item list-group-item-action">
                            <i class="far fa-circle nav-icon"></i>
                            Inventory Ruangan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="ml-auto sidebar-hp">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a href="{{ route('home') }}"
                class="nav-link {{ Request::segment(1) == '' ? 'text-primary' : '' }} row text-center">
                <i class="nav-icon fas
                fa-tachometer-alt"></i>
                <small>Dashboard</small>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link row text-center {{ Request::segment(1) == 'pengaduan' ? 'text-primary' : '' }}"data-bs-toggle="collapse" data-bs-target="#pengaduan"
                aria-expanded="false" aria-controls="pengaduan">
                <i class="nav-icon fas fa-exclamation-circle"></i>
                <small>Pengaduan</small>
            </a>
        </li>
    </ul>
</aside>
