@extends('admin/layouts/main')
@section('nameAplication', 'Permission')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Role & Permission</li>
<li class="breadcrumb-item active">Permission</li>
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <livewire:RolePermission.Permission>
        </div>
    </div>
</section>
@push('js')
@endpush
@endsection