@extends('layouts/index')
@section('title', 'Peminjaman')
@section('content')
<div id="content" class="content">
    @if($peminjaman->count() > 0)
        @foreach($peminjaman as $key => $value)
            <div class="card m-3">
                <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#modal-{{ $value->id }}">
                    <div class="card-body">
                        <h5 class="card-title">Nama: {{ $value->user->name }}</h5>
                        <p class="card-text">NISN: {{ $value->user->nisn }}</p>
                        <p class="card-text">Barang di Pinjam: {{ $value->nama_barang }}</p>
                        <p class="card-text">Tanggal Pinjam: {{ $value->tanggal_pinjam }}</p>
                    </div>
                </a>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal-{{ $value->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="modalLabel-{{ $value->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalLabel-{{ $value->id }}">Kembalikan Barang</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/pengembalian/{{ $value->token }}" class="form-control" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="barang_yang_dikembalikan" class="form-label">Barang yang Kembali</label>
                                    @foreach($barang as $key => $row_barang)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="barang_yang_dikembalikan[]"
                                                value="{{ $row_barang->nama_barang }}" id="barang-{{ $row_barang->id }}">
                                            <label class="form-check-label" for="barang-{{ $row_barang->id }}">
                                                {{ $row_barang->nama_barang }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary" id="savePengembalian">Save</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick=toggleForm()>Kembalikan</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <i class="d-block text-center">Data not found!</i>
    @endif
</div>

<script>
    var modalBody = document.querySelector(".modal-body");
    var modalFooter = document.querySelector(".modal-footer");
    var save = document.getElementById("savePengembalian");

    function toggleForm() {
        modalBody.classList.remove('d-none')
        modalBody.classList.add('d-block')
        modalFooter.classList.add('d-none')
    }

    function update() {
        modalBody.classList.add('d-none')
        modalFooter.classList.add('d-flex')
    }

    update()


</script>

<div class="container-fluid text-center d-flex plus">
    <a class="nav-link bg-primary text-white text-center bullet" href="/add">
        <span>+</span>
    </a>
</div>
@endsection