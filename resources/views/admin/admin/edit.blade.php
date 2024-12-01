@extends('admin/layouts/main')
@section('nameAplication', 'Admin')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">User Manajement</li>
<li class="breadcrumb-item active"><a href="{{route('admin.index')}}">Admin</a></li>
<li class="breadcrumb-item active">Update</li>
@endsection
@section('action')
<a href="{{route('admin.show', $admin->id)}}" class="btn btn-outline-primary rounded-pill">Show</a>
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <form action="{{ route('admin.update', $admin->user->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-center border-bottom border-primary">
                            <p>Authentication</p>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control @error(" email") is-invalid @enderror" id="email"
                                placeholder="name@example.com" value="{{ $admin->user->email }}" name="email" required>
                            <label for="email" class="required">Email address</label>
                            <div class="invalid-feedback">
                                Error : Email, Wajib diisi.
                            </div>
                            @error('email')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Username" id="username" name="username"
                                value="{{ $admin->user->username }}" required oninput="this.value = this.value.replace(/\s/g, '')">
                            <label for="username" class="required">Username</label>
                            <div class="invalid-feedback">
                                Error : Username, Username tidak boleh ada spasi, Wajib diisi.
                            </div>
                            @error('username')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center border-bottom border-primary">
                            <p>Personal</p>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" placeholder="I Made Sena Pernata"
                                value="{{ $admin->name }}" name="name" id="name">
                            <label for="name">Nama Lengkap</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="alamat" placeholder="name@example.com"
                                value="{{ $admin->alamat }}" name="alamat" id="alamat">
                            <label for="alamat">Alamat</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="no_hp" id="nohp" placeholder="Masukksan No HP"
                                value="{{ $admin->no_hp }}" min="0" step="1"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <label for="nohp">No Hp</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="gender" id="gender" class="form-control">
                                <option value="">Pilih jenis Kelamin</option>
                                <optgroup label="Pilih Jenis Kelamin">
                                    <option value="Laki-laki" {{ old('gender', $admin->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender', $admin->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </optgroup>
                            </select>
                            <label for="gender">Gender / Jenis Kelamin</label>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update Admin</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection