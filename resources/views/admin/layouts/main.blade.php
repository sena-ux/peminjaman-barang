<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | @yield('nameAplication')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('sman2amlapura.ico') }}" type="image/x-icon">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('admin_lte') }}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('admin_lte') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
    {{-- admin_lte --}}
    <link rel="stylesheet" href="{{ asset('admin_lte') }}/dist/css/adminlte.min.css">
    {{-- sweetalert --}}
    <link rel="stylesheet" href="{{ asset('admin_lte/plugins/sweetalert2/sweetalert2.min.css') }}">
    {{-- toastr --}}
    <link rel="stylesheet" href="{{ asset('admin_lte/dist/css/custom') }}/style.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">

    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <script src="https://cdn.tiny.cloud/1/2wypsh2fkiiwd54xqk8vahzcuidwf671li2oklbifib476qg/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    @livewireStyles
    @stack('css')
</head>

<body
    class=" {{--dark-mode --}} light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed control-sidebar-slide-open text-sm"
    style="height: auto;">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('sman2amlapura.ico') }}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        @include('admin/layouts/navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin/layouts/sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header p-3">
                <div class="content-header card my-2 p-2 px-3"
                    style="display: flex; justify-content: space-between; align-items: center; width: 100%; flex-direction: row">
                    <div>
                        <h1 class="mt-1">@yield('nameAplication')</h1>
                        <ol class="breadcrumb">
                            @yield('linkLatest')
                        </ol>
                    </div>
                    <div>
                        @yield('action')
                        {{-- <a wire:click='create' class="btn btn-outline-primary rounded-pill"><i
                                class="fa-solid fa-plus px-1"></i>Create New
                            Admin</a> --}}
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            @yield('content')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        @include('admin/layouts/footer')

        {{-- sidebar Mobile --}}
        {{-- @include('admin/layouts/sidebarMobile') --}}
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    {{-- <script src="{{ asset('admin_lte/') }}/plugins/jquery/jquery.min.js"></script> --}}
    {{-- DataTable --}}
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('admin_lte/') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('admin_lte/') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin_lte') }}/dist/js/adminlte.js"></script>
    {{-- Sweetalert --}}
    <script src="{{ asset('admin_lte/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- Script JS --}}
    <script src="{{ asset('admin/dashboard/js') }}/script.js"></script>
    @livewireScripts
    @stack('js')
</body>

</html>