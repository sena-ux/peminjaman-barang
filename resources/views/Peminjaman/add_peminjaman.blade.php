@extends('layouts/index')
@section('title', 'Peminjaman')
@section('content')
    <div class="container mb-5" style="margin-top: 15%;">
        <h2>Form Peminjaman</h2>
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form id="pengembalianForm" style="border:2px black solid; padding:10px; border-radius:10px;" action="" method="post" >
            @csrf
            <div class="form-group">
                <label for="name">Nama</label>
                <select name="name" id="name" class="form-control">
                    @foreach($siswa as $key => $row_siswa)
                        <option class="form-control" value="{{ $row_siswa->id }}">{{ $row_siswa->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <div id="nama_barang">
                    @foreach($barang as $key => $row_barang)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="nama_barang[]" value="{{ $row_barang->nama_barang }}" id="nama_barang">
                            <label class="form-check-label" for="nama_barang">
                                {{ $row_barang->nama_barang }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label for="tanggal_pinjam">Tanggal</label>
                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" readonly>
            </div>
            <div class="form-group">
                <label for="keperluan">Keperluan</label>
                <input type="text" class="form-control" id="keperluan" name="keperluan">
            </div>
            <div class="d-flex justify-content-between w-100">
                <a href="/register" class="btn btn-warning mt-3">Register</a>
                <button type="submit" class="btn btn-primary mt-3">Pinjam</button>
            </div>
            
        </form>

        <script>
            document.getElementById("tanggal_pinjam").value = new Date().toISOString().slice(0, 10);
        </script>
    </div>
@endsection
