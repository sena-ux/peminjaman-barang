@extends('admin/layouts/main')
@section('nameAplication', 'Staf')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">User Manajement</li>
<li class="breadcrumb-item active">Staf</li>
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <livewire:user.staf>
        </div>
    </div>
</section>
@endsection