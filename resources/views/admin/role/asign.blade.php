@extends('admin/layouts/main')
@section('nameAplication', 'Role')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Role & Permission</li>
<li class="breadcrumb-item active"><a href="{{route('role.index')}}">Role</a></li>
<li class="breadcrumb-item active">Asign Role</li>
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <livewire:RolePermission.AsignRole>
        </div>
    </div>
</section>
@push('js')
@endpush
@endsection