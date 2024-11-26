<aside class="main-sidebar sidebar-light-primary elevation-4 overflow-auto pb-4"
    style="scrollbar-width: none; max-height: 100vh; overflow: auto;" id="navbarDekstop">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="text-dark p-3">
        <div class="row d-flex flex-row justify-content-center">
            <img src="{{ asset('sman2amlapura.ico') }}" alt="Logo Aplikasi Sarpras" class="" style="width: 150px;">
            <span class="font-weight-light text-center">{{ config('app.name') }}</span>
        </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar mt-0">
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ Request::segment(1) == '' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('umum.index') }}"
                        class="nav-link {{ Request::segment(1) == 'pengaduan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-exclamation-circle"></i>
                        <p>
                            Kerusakan
                            {{-- <i class="fas fa-angle-left right"></i> --}}
                        </p>
                    </a>
                    {{-- <ul class="nav nav-treeview"> --}}
                        {{-- <li class="nav-item">
                            <a href="{{ route('umum.index') }}"
                                class="nav-link {{ Request::segment(2) == 'umum' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengaduan Umum</p>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kebutuhan Ruangan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('barangrk.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inventory Ruangan</p>
                            </a>
                        </li> --}}
                        {{--
                    </ul> --}}
                </li>

                @role('admin|petugas|staff|superadmin')
                <li class="nav-header">Umum</li>
                <li class="nav-item">
                    <a href="{{ route('kelas.index') }}"
                        class="nav-link {{ Request::segment(2) == 'kelas' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-grid-2"></i>
                        <p>Kelas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ruangan.index') }}"
                        class="nav-link {{ Request::segment(2) == 'ruangan' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-grid-2"></i>
                        <p>Ruangan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}"
                        class="nav-link {{ Request::segment(2) == 'category' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-grid-2"></i>
                        <p>Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sarana.index') }}"
                        class="nav-link {{ Request::segment(2) == 'sarana' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-grid-2"></i>
                        <p>Sarana</p>
                    </a>
                </li>
                <li class="nav-header">Management Barang</li>
                <li class="nav-item">
                    <a href="{{ route('barang.index') }}"
                        class="nav-link {{ Request::segment(2) == 'barang' && Request::segment(3) == '' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Barang
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('inventory.index') }}"
                        class="nav-link {{ Request::segment(3) == 'inventoryBarangModel' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Inventory Barang</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Barang Kelas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Barang Kebersihan</p>
                    </a>
                </li> --}}
                @endrole
                @role('admin|petugas|staff|superadmin')
                <li class="nav-header">Regulasi</li>
                <li class="nav-item">
                    <a href="{{ route('pemeliharaan.index') }}"
                        class="nav-link {{ Request::segment(2) == 'regulasi' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Pemeliharaan
                            {{-- <i class="fas fa-angle-left right"></i> --}}
                        </p>
                    </a>
                </li>
                @endrole
                @role('superadmin|staf|admin')
                <li class="nav-header">Master Data</li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ Request::segment(2) == 'user' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            User Manajement
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @role('staf|admin|superadmin')
                        <li class="nav-item">
                            <a href="{{ route('siswa.index') }}"
                                class="nav-link {{ Request::segment(3) == 'siswa' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Siswa</p>
                            </a>
                        </li>
                        @endrole
                        @role('admin|superadmin')
                        <li class="nav-item">
                            <a href="{{route('staf.index')}}"
                                class="nav-link {{ Request::segment(3) == 'staf' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Staf</p>
                            </a>
                        </li>
                        @endrole
                        @role('superadmin')
                        <li class="nav-item">
                            <a href="{{route('admin.index')}}"
                                class="nav-link {{ Request::segment(3) == 'admin' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Admin</p>
                            </a>
                        </li>
                        @endrole
                    </ul>
                </li>
                @endrole
                @role('superadmin')
                <li class="nav-header">Role</li>
                <li class="nav-item">
                    <a href="{{ route('role.index') }}"
                        class="nav-link {{ Request::segment(2) == 'role' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-grid-2"></i>
                        <p>Role</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('asignrole.index') }}"
                        class="nav-link {{ Request::segment(2) == 'asignrole' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-grid-2"></i>
                        <p>Asign Role</p>
                    </a>
                </li>
                <li class="nav-header">Permission</li>
                <li class="nav-item">
                    <a href="{{ route('permission.index') }}"
                        class="nav-link {{ Request::segment(2) == 'permission' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-grid-2"></i>
                        <p>Permission</p>
                    </a>
                </li>
                @endrole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>