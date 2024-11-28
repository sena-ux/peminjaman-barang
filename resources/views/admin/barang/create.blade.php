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
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <div
                class="bg-black p-2 my-2 rounded d-flex justify-content-between align-item-center text-align-center align-middle">
                <h6>Create New Barang</h6>
            </div>
            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="form-row">
                    <div class="col-md-6 p-2">
                        <label for="namaBarang" class="required">Nama Barang</label>
                        <input type="text" name="name" id="namaBarang" class="form-control"
                            placeholder="Nama Barang : AC Daikin" required>
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="sumberDana" class="required">Sumber Dana</label>
                        <input type="text" name="sumber_dana" id="sumberDana" class="form-control"
                            placeholder="Sumber Dana : Dana Bos" required>
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="tahun_pengadaan" class="required">Tahun Pengadaan</label>
                        <input type="text" name="tahun_pengadaan" id="tahun_pengadaan" class="form-control"
                            placeholder="Contoh: 2024" title="Masukkan 4 digit tahun, contoh: 2024" required>
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="harga_barang">Harga Barang</label>
                        <input type="number" name="harga_barang" id="harga_barang" class="form-control"
                            placeholder="Opsional">
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="foto_barang" class="required">Foto Barang</label>
                        <input type="file" name="foto_barang" id="foto_barang" class="form-control"
                            placeholder="Upload gambar" accept="png,jpg,jpeg,JPG,PNG,JPEG,gif,GIF" required>
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
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="total_barang">Total Barang</label>
                        <input type="number" name="total_barang" id="total_barang" class="form-control">
                    </div>
                    <div class="col-md-6 p-2">
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