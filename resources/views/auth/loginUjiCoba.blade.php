@extends('layouts/index')
@section('title', 'Login')
@section('content')
@section('name_page', 'Login terlebih dahulu')
<div id="content" class="content row justify-content-center">
    <div class="container col-md-6 p-5">
        <h2 class="mb-4 text-underline"><u>Login</u></h2>
        <form id="login" class="needs-validation" style="border:2px black solid; padding:10px; border-radius:10px;" action="{{ route('login') }}" method="post" novalidate>
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">NISN</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your nisn" value="{{ old('username') }}" required minlength="5">
                @error('username')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Wajib di sini, minlength 8.
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required minlength="8">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Wajib di sini, minlength 8.
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" id="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>
@push('script')
    <script src="{{asset('auth/auth.js')}}"></script>
@endpush
@endsection