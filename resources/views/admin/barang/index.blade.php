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
            <livewire:Barang.barang>
        </div>
        {{-- {!! $dataTable->table(['class' => 'table table-bordered table-striped bg-dark text-dark']) !!} --}}
    </div>
</section>
@push('js')
{{-- <script src="{{asset('script/barang/ajax.js')}}"></script> --}}
{{-- {!! $dataTable->scripts() !!} --}}
@endpush
@endsection