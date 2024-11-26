@extends('admin/layouts/main')
@section('nameAplication', 'Kerusakan Umum')
@section('content')
@section('linkLatest')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Pengaduan</li>
    <li class="breadcrumb-item active">Kerusakan Umum</li>
@endsection
<section class="content">
    <div class="container-fluid">
        {!! $dataTable->table(['class' => 'table table-bordered table-striped bg-dark text-dark']) !!}
    </div>
</section>
@push('js')
    <script>
        const barangData = @json($barang);
    </script>
    <script src="{{ asset('script/pengaduan/kerusakan/umum.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endpush
@endsection
