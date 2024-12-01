@extends('admin/layouts/main')
@section('nameAplication', 'Peminjaman Barang')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Regulasi</li>
<li class="breadcrumb-item"><a href="{{route('barangPinjam.index')}}">Barang Pinjam</a></li>
<li class="breadcrumb-item active">Peminjaman Barang</li>
@section('action')
    <a href="{{route('barangPinjam.index')}}" class="btn btn-outline-primary">Barang Pinjam</a>
@endsection
@endsection
<section class="content">
    <div class="container-fluid">
        
            <livewire:Regulasi.PeminjamanBarang>
    </div>
</section>
@push('js')
@endpush
@endsection