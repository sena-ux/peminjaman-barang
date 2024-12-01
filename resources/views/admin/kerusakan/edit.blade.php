@extends('admin/layouts/main')
@section('nameAplication', 'Kerusakan')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Kerusakan Management</li>
<li class="breadcrumb-item active"><a href="{{route("kerusakan.index")}}">Kerusakan</a></li>
<li class="breadcrumb-item active">Create</li>
@section('action')
<a href="{{route("kerusakan.index")}}" class="btn btn-outline-primary">Kembali</a>
@endsection
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <form action="{{ route('kerusakan.update', $kerusakan->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-row">
                    <div class="col-md-6 p-2">
                        <label for="namaKerusakan" class="required">Nama Kerusakan</label>
                        <input type="text" name="name" id="namaKerusakan" class="form-control"
                            placeholder="Masukkan judul kerusakan..." value="{{$kerusakan->name}}" required>
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="tingkatKerusakan" class="required">Tingkat Kerusakan</label>
                        <select name="tingkat_kerusakan" id="tingkatKerusakan" class="form-control">
                            <option value="{{$kerusakan->tingkat_kerusakan}}">{{ Str::ucfirst($kerusakan->tingkat_kerusakan)}}</option>
                            <optgroup label="Tingkat">
                                <option value="rendah">Rendah</option>
                                <option value="sedang">Sedang</option>
                                <option value="tinggi">Tinggi</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-12 p-2">
                        <label for="detail_kerusakan" class="required">Detail Kerusakan</label>
                        <textarea name="detail_kerusakan" class="form-control tinyMce fullAccess" id="detail_kerusakan" cols="30"
                            rows="10" style="height: 100vh; width: 100%;">
                            {!! $kerusakan->detail_kerusakan !!}
                        </textarea>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Kerusakan</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection