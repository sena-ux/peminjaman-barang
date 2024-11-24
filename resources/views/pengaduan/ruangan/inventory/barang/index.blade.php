@extends('admin/layouts/main')
@section('nameAplication', 'Pengaduan Umum')
@section('content')
@section('linkLatest')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('umum.index') }}">Inventory Ruangan Kelas</a></li>
    <li class="breadcrumb-item active">Inventory Ruang Kelas</li>
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            {{-- @livewire('ruangan.kelas.InventoryRuangKelasBarang') --}}
            <div class="p-2">
                {!! $dataTable->table(['class' => 'table table-dark table-striped']) !!}
            </div>
        </div>
    </div>
</section>
@push('js')
    {!! $dataTable->scripts() !!}
    <script>
        window.setKondisi = @json($setKondisi);
    </script>
    <script src="{{ asset('script/pengaduan/inventory/ruangan/kelas/barang.js') }}"></script>
@endpush
@endsection
