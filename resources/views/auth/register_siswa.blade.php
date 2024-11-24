@extends('layouts/index')
@section('title', 'Login')
@section('content')
@section('name_page', 'Register Siswa')
<div id="content" class="content">
    <div class="container">
        <div class="register">
            <form id="register" class="w-0 needs-validation"
                style="border:2px black solid; padding:10px; border-radius:10px;" action="{{route('register')}}" method="post" novalidate>
                @csrf
                <div class="row col-md-12 g-3">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter your name" value="{{ old('name') }}" required minlength="8" maxlength="12">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Wajib di sini, minlength 8, maxlength 12.
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter your email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Wajib di sini.
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Enter your username" value="{{ old('username') }}" required minlength="5" maxlength="20">
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Wajib di sini, minlength 8, maxlength 12.
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" oninput="validateNumber(this)" class="form-control" id="no_hp" name="no_hp"
                            placeholder="Enter your no_hp" value="{{ old('no_hp') }}" required minlength="11" maxlength="15">
                        @error('no_hp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Wajib di sini, minlength 11, maxlength 12.
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" oninput="validateNumber(this)" class="form-control" id="nisn" name="nisn"
                            placeholder="Enter your nisn" value="{{ old('nisn') }}" required minlength="10" maxlength="15">
                        @error('nisn')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Wajib di sini, minlength 10, maxlength 15.
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" oninput="validateNumber(this)" class="form-control" id="nis" name="nis"
                            placeholder="Enter your nis" value="{{ old('nis') }}" required minlength="4" maxlength="10">
                        @error('nis')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Wajib di sini, minlength 8, maxlength 12.
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas"
                            placeholder="Enter your kelas" value="{{ old('kelas') }}" required>
                        @error('kelas')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Wajib di sini.
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter your password" required minlength="8" maxlength="20">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Wajib di sini, minlength 8, maxlength 20.
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password"
                            name="password_confirmation" placeholder="Confirm your password" required>
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Wajib di sini.
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <input type="hidden" class="form-control" id="role" name="role"
                            placeholder="Enter your role" value="guru">
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" id="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>


    </div>
</div>
@push('script')
    <script src="{{ asset('auth/auth.js') }}"></script>
@endpush
@endsection
