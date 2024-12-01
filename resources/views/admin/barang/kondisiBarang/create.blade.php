@extends('admin/layouts/main')
@section('nameAplication', 'Barang')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Barang Management</li>
<li class="breadcrumb-item active">Barang</li>
@section('action')
<a href="{{route('inventory.index')}}" class="btn btn-primary">Kembali</a>
@endsection
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">

            <form action="{{route('kondisiBarang.store')}}" method="post" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="row">
                    <input type="hidden" name="inv_brg_id" value="{{Request::query('kv')}}">
                    <div class="col-4">
                        <label for="date" class="required">Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
                    <div class="col-4">
                        <label for="kondisi" class="required">Kondisi</label>
                        <select class="custom-select" name="kondisi" id="kondisi" required>
                            <option value="" selected>Open this select Kondisi</option>
                            <optgroup label="List Kondisi">
                                @forelse ($kondisi as $item)
                                <option value="{{$item['name']}}">{{ $item['name'] }}</option>
                                @empty
                                <option value="" disabled>No Data</option>
                                @endforelse
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="status" class="required">Status</label>
                        <select class="custom-select" name="status" id="status" required>
                            <option value="" selected>Open this select Status</option>
                            <optgroup label="List Ststuas">
                                @forelse ($status as $item)
                                <option value="{{$item['name']}}">{{ $item['name'] }}</option>
                                @empty
                                <option value="" disabled>No Data</option>
                                @endforelse
                            </optgroup>
                        </select>
                    </div>
                    {{-- <div class="form-group">
                        <label for="images" class="required">Upload Images</label>
                        <input type="file" name="images" id="images" class="form-control"
                            accept=".png,.jpg,.jpeg,JPG,PNG,JPEG,.gif,.GIF">
                    </div> --}}
                    <div class="col-12">
                        <label for="detail">Detail Kondisi Barang</label>
                        <textarea name="detail_kondisi" style="height: 100vh;" id="detail" cols="100" rows="10"
                            class="tinyMce fullAccess">
                                    <h1 style="text-align: center;">Detail Kerusakan {{ $inventory->barang->nama_barang }}</h1>
                                    <caption>Detail Kerusakan</caption>
                                    <table border="1" class="table table-bordered" style="width: 100%; table-layout: fixed; word-wrap: break-word; border-collapse: collapse;">
                                        <tr>
                                            <td style="width: 30%;">Nama Barang</td>
                                            <td style="width: 70%; ">{{ $inventory->barang->nama_barang }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Kode Barang</td>
                                            <td style="width: 70%; ">{{ $inventory->kode_barang }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jenis </td>
                                            <td>{{ $inventory->barang->category->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Ruangan </td>
                                            <td>{{ $inventory->ruangan->nama_ruangan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Foto Barang </td>
                                            <td><img src="{{ asset($inventory->barang->foto_barang) }}" alt="" class="img-fluid img-thumbnail"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Penjelasan Detail Kerusakan</td>
                                            <td style="width: 70%; "> </td>
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
                                            <td>Jumlah </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Foto Kerusakan </td>
                                            <td></td>
                                        </tr>
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
                                    </table>
                                </textarea>
                    </div>
                </div>
                <div class="text-end py-2">
                    <button type="submit" class="btn btn-primary" id="create-kondisi">Create Kondisi Barang</button>
                </div>
            </form>
        </div>
    </div>
</section>
@push('js')
@endpush
@endsection