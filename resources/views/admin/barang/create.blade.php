@extends('admin/layouts/main')
@section('nameAplication', 'Barang')
@push('css')
{{-- <script>
    tinymce.init({
      selector: 'textarea#deskripsiBarang',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
</script> --}}
@endpush
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Barang Management</li>
<li class="breadcrumb-item active"><a href="{{route('barang.index')}}">Barang</a></li>
<li class="breadcrumb-item active">Create</li>
@section('action')
<a href="{{route('barang.index')}}" class="btn btn-outline-info">Back</a>
@endsection
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="form-row">
                    <div class="col-md-6 p-2">
                        <label for="namaBarang" class="required">Nama Barang</label>
                        <input type="text" name="name" id="namaBarang" class="form-control"
                            placeholder="Nama Barang : AC Daikin" aria-describedby="nama_barang_help" required>
                        <small id="nama_barang_help" class="form-text text-muted">Note : <b
                                class="text-danger">required</b></small>
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="foto_barang" class="required">Foto Barang</label>
                        <input type="file" name="foto_barang" id="foto_barang" class="form-control"
                            placeholder="Upload gambar" accept=".png,.jpg,.jpeg,JPG,PNG,JPEG,gif,GIF" required>
                        <small class="form-text text-muted">Note : <b class="text-danger">required</b></small>
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="category" class="required">Select Category</label>
                        <select class="custom-select" name="category" id="category" required>
                            <option value="" selected>Open this select menu</option>
                            <optgroup label="Categories">
                                @forelse ($categorys as $item)
                                <option value="{{$item->id}}">{{ $item->name }}</option>
                                @empty
                                <option value="" disabled>No Data</option>
                                @endforelse
                            </optgroup>
                        </select>
                        <small class="form-text text-muted">Note : <b class="text-danger">required</b></small>
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="sumberDana">Sumber Dana</label>
                        <input type="text" name="sumber_dana" id="sumberDana" class="form-control"
                            placeholder="Sumber Dana : Dana Bos">
                        <small class="form-text text-muted">Note : <b>Kalau tidak tahun kosongkang saja.</b></small>
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="tahun_pengadaan">Tahun Pengadaan</label>
                        <input type="text" name="tahun_pengadaan" id="tahun_pengadaan" class="form-control"
                            placeholder="Contoh: 2024" title="Masukkan 4 digit tahun, contoh: 2024">
                        <small class="form-text text-muted">Note : <b>Kalau tidak tahun kosongkang saja.</b></small>
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="harga_barang">Harga Barang</label>
                        <input type="number" name="harga_barang" id="harga_barang" class="form-control"
                            placeholder="Opsional">
                        <small class="form-text text-muted">Note : <b>Kalau tidak tahun kosongkang saja.</b></small>
                    </div>
                    {{-- <div class="col-md-6 p-2">
                        <label for="total_barang">Total Barang</label>
                        <input type="number" name="total_barang" id="total_barang" class="form-control">
                    </div> --}}
                    <div class="col-md-12 p-2">
                        <label for="deskripsiBarang">Deskripsi Barang</label>
                        <textarea name="deskripsi" id="deskripsiBarang" class="form-control" cols="30"
                            rows="10"></textarea>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Create & Other Barang</button>
                </div>
            </form>
        </div>
    </div>
</section>
@push('js')
<script src="{{asset('script/barang/ajax.js')}}"></script>
@endpush
@endsection