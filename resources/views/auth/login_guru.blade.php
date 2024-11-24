@extends('layouts/index')
@section('title', 'Login')
@section('content')
@section('name_page', 'Login Guru')
<div id="content" class="content row justify-content-center">
    <div class="container col-md-6 mb-5 mt-3">
        <h2 class="mb-4">Login Guru</h2>
        <form id="register" style="border:2px black solid; padding:10px; border-radius:10px;" action="" method="post">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Enter your nisn" value="{{ old('nisn') }}">
                @error('nisn')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm-password" name="password_confirmation" placeholder="Confirm your password">
                @error('password_confirmation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-between">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" id="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
</div>
@endsection