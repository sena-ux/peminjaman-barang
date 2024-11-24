@extends('admin/layouts/main')
@section('nameAplication', 'Dashboard')
@section('content')
@section('linkLatest')
    <li class="breadcrumb-item active">Home</li>
@endsection
<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-th-large"></i>
                    Menu
                </h3>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <h5>Laporan Siswa</h5>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $pengaduanCount }}</h3>

                                <p>New Pengaduan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <a href="{{route('umum.index')}}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                @role('superadmin')
                    <div class="col-12">
                        <h5>Master Data</h5>
                    </div>
                    <div class="row">
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small card -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $siswaCount }}<sup style="font-size: 20px"></sup></h3>

                                    <p>Siswa</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="{{ route('siswa.index') }}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small card -->
                            <div class="small-box bg-navy">
                                <div class="inner">
                                    <h3>{{$stafCount}}<sup style="font-size: 20px"></sup></h3>

                                    <p>Staf</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <a href="{{route('staf.index')}}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small card -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{$adminCount}}</h3>

                                    <p>Admin</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-lock"></i>
                                </div>
                                <a href="{{route('admin.index')}}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                    @endrole
                </div>
            </div>
        </div>

    </div><!--/. container-fluid -->
</section>

@push('js')
    <script src="{{ asset('admin/dashboard/js/home/home.js') }}"></script>
@endpush
@endsection
