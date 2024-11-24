@extends('layouts/index')
@section('title', 'Login')
@section('content')
@section('name_page', 'Register Guru')
<div id="content" class="content">
    <div class="container">
        {{-- @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif --}}
        <div class="register mt-3">
            <form id="register" class="w-0 needs-validation" style="border:2px black solid; padding:10px; border-radius:10px;"
                action="{{route('register')}}" method="post" novalidate>
                @csrf
                <div class="row p-3">
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
                            placeholder="Enter your username" value="{{ old('username') }}" required minlength="5" maxlength="8">
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
                        <input type="number" class="form-control" id="no_hp" name="no_hp"
                            placeholder="Enter your no_hp" value="{{ old('no_hp') }}" required minlength="8" maxlength="12">
                        @error('no_hp')
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
                        <label for="nip" class="form-label">NIP</label>
                        <input type="number" class="form-control" id="nip" name="nip"
                            placeholder="Enter your nip" value="{{ old('nip') }}" required minlength="18" maxlength="20">
                        @error('nip')
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
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter your password" required minlength="8" maxlength="12">
                        @error('password')
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
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" name="password_confirmation"
                            placeholder="Confirm your password" required>
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
                            placeholder="Enter your role" value="siswa">
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
