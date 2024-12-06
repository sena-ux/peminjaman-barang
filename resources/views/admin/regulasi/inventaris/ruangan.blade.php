@extends('admin/layouts/main')
@section('nameAplication', 'Inventaris')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Regulasi</li>
<li class="breadcrumb-item active">Kartu Inventaris Ruangan</li>
@endsection
<section class="content">
    <div class="container-fluid">
        <livewire:Regulasi.Inventaris.Ruangan>
    </div>
</section>
@push('js')
@endpush
@endsection