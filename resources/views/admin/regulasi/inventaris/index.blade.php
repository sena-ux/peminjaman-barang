@extends('admin/layouts/main')
@section('nameAplication', 'Inventaris')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Regulasi</li>
<li class="breadcrumb-item active">Kartu Inventaris Ruangan</li>
<li class="breadcrumb-item active">List Ruangan</li>
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <livewire:Regulasi.Inventaris>
        </div>
    </div>
</section>
@push('js')
@endpush
@endsection