@extends('admin/layouts/main')
@section('nameAplication', 'Barang')
@section('content')
{{-- @section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Barang Management</li>
<li class="breadcrumb-item active">Barang</li>
@endsection --}}
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <livewire:Umum.kerusakan>
        </div>
    </div>
</section>
@endsection