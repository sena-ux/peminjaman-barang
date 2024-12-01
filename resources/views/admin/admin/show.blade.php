@extends('admin/layouts/main')
@section('nameAplication', 'Admin')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">User Manajement</li>
<li class="breadcrumb-item active"><a href="{{route('admin.index')}}">Admin</a></li>
<li class="breadcrumb-item active">Show Admin</li>
@endsection
@section('action')
<a href="{{route('admin.edit', $admin->id)}}" class="btn btn-outline-primary rounded-pill">Update</a>
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-center border-bottom border-primary">
                        <p>Authentication</p>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email"
                            placeholder="name@example.com" name="email" value="{{ $admin->user->email }}" disabled>
                        <label for="email" class="required">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Username" id="username" name="username" value="{{ $admin->user->username }}" disabled>
                        <label for="username" class="required">Username</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center border-bottom border-primary">
                        <p>Personal</p>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" placeholder="I Made Sena Pernata"
                            value="{{ $admin->name }}" name="name" id="name" disabled>
                        <label for="name">Nama Lengkap</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="alamat" placeholder="name@example.com"
                            value="{{ $admin->alamat }}" name="alamat" id="alamat" disabled>
                        <label for="alamat">Alamat</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="no_hp" id="nohp" placeholder="Masukksan No HP"
                            value="{{ $admin->no_hp }}" min="0" step="1"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" disabled>
                        <label for="nohp">No Hp</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" disabled value="{{ $admin->gender }}">
                        <label for="gender">Gender / Jenis Kelamin</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection