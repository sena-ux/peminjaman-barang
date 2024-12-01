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
            <form action="{{ route('kerusakan.store') }}" method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="form-row">
                    <div class="col-md-6 p-2">
                        <label for="namaKerusakan" class="required">Nama Kerusakan</label>
                        <input type="text" name="name" id="namaKerusakan" class="form-control"
                            placeholder="Masukkan judul kerusakan..." required>
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="tingkatKerusakan" class="required">Tingkat Kerusakan</label>
                        <select name="tingkat_kerusakan" id="tingkatKerusakan" class="form-control">
                            <option value="">Select Tingkat Kerusakan</option>
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
                        <h1 style="text-align: center;">Detail Kerusakan</h1>
                        <caption>Detail Kerusakan</caption>
                        <table border="1" class="table table-bordered" style="width: 100%; table-layout: fixed; word-wrap: break-word; border-collapse: collapse;">
                            <tr>
                                <td style="width: 30%;">Kronologi Kerusakan</td>
                                <td style="width: 70%; "> </td>
                            </tr>
                            <tr>
                                <td>Deskripsi singkat </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Apa saja yang rusak </td>
                                <td>
                                    <ol>
                                        <li></li>
                                    </ol>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Lokasi </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Ruangan </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Jumlah </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Foto Kerusakan </td>
                                <td></td>
                            </tr>
                            @can('perbaikan kerusakan')
                            <tr>
                                <td colspan="2" style="text-align: center;" contenteditable="true">Disini saat perbaikan di lakukan.</td>
                            </tr>
                            <tr>
                                <td>Perbaikian </td>
                                <td>
                                    <ul>
                                        <li></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Foto Sebelum </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Foto Sesudah </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Foto Dalam Pengerjaan </td>
                                <td></td>
                            </tr>
                            @endcan
                        </table>
                        </textarea>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Create & Other Kerusakan</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection