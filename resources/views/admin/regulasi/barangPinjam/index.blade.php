@extends('admin/layouts/main')
@section('nameAplication', 'Barang Pinjam')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <livewire:Regulasi.BarangPinjam>
        </div>
    </div>
</section>
@endsection