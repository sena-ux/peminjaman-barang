@extends('admin/layouts/main')
@section('nameAplication', 'Category')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Regulasi</li>
<li class="breadcrumb-item active">Category</li>
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <livewire:Umum.Category>
        </div>
    </div>
</section>
@push('js')
@endpush
@endsection