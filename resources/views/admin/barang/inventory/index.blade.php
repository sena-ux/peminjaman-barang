@extends('admin/layouts/main')
@section('nameAplication', 'Inventory Barang')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Barang Management</li>
<li class="breadcrumb-item active">Inventory Barang</li>
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <livewire:Barang.InventoryBarang>
        </div>
    </div>
</section>
@push('js')
<script src="{{asset('script/barang/ajax.js')}}"></script>
@endpush
@endsection