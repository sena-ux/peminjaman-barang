@extends('admin/layouts/main')
@section('nameAplication', 'Pemeliharaan')
@push('css')
<script>
    tinymce.init({
    selector: 'textarea#dokumen-pendukung',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    file_picker_types: 'file image media',
    block_unsupported_drop: false,
    automatic_uploads: true,
    images_upload_url: '/upload',
    file_picker_types: 'image',
    file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.onchange = function() {
            var file = this.files[0];

            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);
                cb(blobInfo.blobUri(), { title: file.name });
            };
        };
        input.click();
    }
});

</script>
@endpush
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Regulasi</li>
<li class="breadcrumb-item active">Pemeliharaan</li>
<li class="breadcrumb-item active">Create</li>
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-2 table-responsive">
            <div class="bg-secondary p-2 my-2 rounded d-flex justify-content-between align-items-center">
                <h5>Create Pemeliharaan</h5>
                <a href="{{route('pemeliharaan.index')}}" class="btn btn-primary">Kembali</a>
            </div>
            <form action="{{ route('pemeliharaan.store') }}" method="POST" enctype="multipart/form-data"
                class="mt-2 needs-validation" novalidate>
                @method('POST')
                @csrf
                <div class="row">
                    <div class="form-group mb-3 col-md-6">
                        <label for="nama" class="required">Sarana</label>
                        <select name="sarana_id" id="" class="form-control" id="nama" aria-describedby="nameSaranaHelp"
                            placeholder="Silahkan pilih sarana terlebih dahulu." required>
                            <option value="">Select Sarana</option>
                            <optgroup label="Sarana yang tersedia">
                                @forelse ($sarana as $item)
                                <option value="{{$item->id}}">{{ $item->nama_sarana }}</option>
                                @empty
                                <option value="" disabled>Tidak ada data sarana.</option>
                                @endforelse
                            </optgroup>
                        </select>
                        <small id="nameSaranaHelp" class="form-text text-muted">Silahkan pilih sarana terlebih
                            dahulu.</small>
                        <div class="invalid-feedback">
                            Field wajib diisi.
                        </div>
                        @error('sarana_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label for="kode_barang">Barang</label>
                        <input type="text" class="form-control" id="kode_barang" aria-describedby="kode_barangHelp"
                            placeholder="Inputkan Kode Barang." name="kode_barang">
                        <small id="kode_barangHelp" class="form-text text-muted">Note : Jika ini pemeliharaan barang
                            seperti : AC, Speaker, Kabel DLL silahkan masukkan kode barang / nama barang nya jika bersifat global tersebut.</small>
                        @error('kode_barang')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <div class="invalid-feedback">
                            Field wajib diisi.
                        </div>
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label for="jenis" class="required">Jenis Pemeliharaan</label>
                        <input type="text" class="form-control" id="jenis" aria-describedby="namePemeliharaanHelp"
                            placeholder="Inputkan jenis pemeliharaan." name="jenis_pemeliharaan" required>
                        <small id="namePemeliharaanHelp" class="form-text text-muted">Silahkan inputkan Jenis
                            Pemeliharaan, Misalnya : Perbaikan, Penggantian, DLL.</small>
                        @error('jenis_pemeliharaan')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <div class="invalid-feedback">
                            Field wajib diisi.
                        </div>
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label for="jenis" class="required">Category Pemeliharaan</label>
                        <select name="category" id="" class="form-control" id="nama" aria-describedby="nameSaranaHelp"
                            placeholder="Silahkan pilih sarana terlebih dahulu." required>
                            <option value="" selected>Select Category</option>
                            <optgroup label="Category yang tersedia">
                                <option value="Umum">Umum</option>
                                <option value="Semester">Semester</option>
                                <option value="Triwulan">Triwulan</option>
                                <option value="Harian">Harian</option>
                            </optgroup>
                        </select>
                        <small id="namePemeliharaanHelp" class="form-text text-muted">Silahkan Select Category
                            Pemeliharaan.</small>
                        @error('jenis_pemeliharaan')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <div class="invalid-feedback">
                            Field wajib diisi.
                        </div>
                    </div>
                    <div class="col md 6 mb-3">
                        <div class="row">
                            <label for="">Periode</label>
                            <div class="form-group mb-3 col-md-6">
                                <label for="tanggal_mulai" class="required">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" aria-describedby="dateHelp"
                                    placeholder="Inputkan tanggal mulai pemeliharaan." name="tanggal_mulai" required>
                                <small id="dateHelp" class="form-text text-muted">Silahkan inputkan tanggal awal mulai
                                    pemeliharaan.</small>
                                @error('tanggal_mulai')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="invalid-feedback">
                                    Field wajib diisi.
                                </div>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="tanggal_selesai" class="required">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" aria-describedby="dateHelp"
                                    placeholder="Inputkan tanggal selesai pemeliharaan." name="tanggal_selesai" required>
                                <small id="dateHelp" class="form-text text-muted">Silahkan inputkan tanggal selesai
                                    pemeliharaan.</small>
                                @error('date')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="invalid-feedback">
                                    Field wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-6">
                        <label for="biaya" class="required">Biaya</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Rp.</span>
                            <input type="text" class="form-control" id="biaya" aria-describedby="biayaHelp" required>
                            <span class="input-group-text">,00</span>
                        </div>
                        <small id="biayaHelp" class="form-text text-muted">Masukkan berapa biaya yang
                            dikeluarkan.</small>
                        @error('biaya')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <div class="invalid-feedback">
                            Field wajib diisi.
                        </div>

                        <input type="hidden" id="biayaHidden" name="biaya">
                    </div> --}}

                    {{-- <div class="form-group mb-3 col-md-6">
                        <label for="sumberDana" class="required">Sumber Dana</label>
                        <input type="text" class="form-control" id="sumberDana" aria-describedby="sumberdanaHelp"
                            name="sumber_dana" required>
                        <small id="sumberdanaHelp" class="form-text text-muted">Contoh : Dana Bos.</small>
                        @error('sumberdana')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <div class="invalid-feedback">
                            Field wajib diisi.
                        </div>
                    </div> --}}

                    <div class="form-group mb-3 col-md-6">
                        <label for="penanggung_jawab" class="required">Penanggung Jawab</label>
                        <input type="text" class="form-control" id="penanggung_jawab"
                            aria-describedby="penanggung_jawabHelp" name="penanggung_jawab" required>
                        <small id="penanggung_jawabHelp" class="form-text text-muted">Masukkan nama lengkah penanggung
                            jawab.</small>
                        @error('penanggung_jawab')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <div class="invalid-feedback">
                            Field wajib diisi.
                        </div>
                    </div>
                    {{-- <div class="form-group mb-3 col-md-6">
                        <label for="kondisi_sebelum" class="required">Foto Sebelum</label>
                        <input type="file" class="form-control" id="kondisi_sebelum"
                            aria-describedby="kondisi_sebelumHelp" name="kondisi_sebelum" required>
                        <small id="kondisi_sebelumHelp" class="form-text text-muted">Masukkan Foto Sebelum
                            pengerjaan.</small>
                        @error('kondisi_sebelum')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <div class="invalid-feedback">
                            Field wajib diisi.
                        </div>
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label for="kondisi_sesudah" class="required">Foto Sesudah</label>
                        <input type="file" class="form-control" id="kondisi_sesudah"
                            aria-describedby="kondisi_sesudahHelp" name="kondisi_sesudah" required>
                        <small id="kondisi_sesudahHelp" class="form-text text-muted">Masukkan Foto Sesudah
                            pengerjaan.</small>
                        @error('kondisi_sesudah')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <div class="invalid-feedback">
                            Field wajib diisi.
                        </div>
                    </div> --}}
                    <div class="form-group mb-3 col-md-12">
                        <label for="dokumen-pendukung" class="required">Dokumen Pendukung Lainnya</label>
                        <textarea name="dokumen_pendukung" cols="30" rows="10"
                            class="form-control tinyMce fullAccess" style="height: 100vh;"></textarea>
                        <div class="invalid-feedback">
                            Field wajib diisi.
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary">Reset Form</button>
                    <div class="d-flex align-item-center">
                        <div class="spinner-border text-primary mr-2" role="status" wire:loading wire:target="store">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-primary">Create New Pemeliharaan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@push('js')
<script>
    const inputBiaya = document.getElementById('biaya');
    const hiddenBiaya = document.getElementById('biayaHidden');

    inputBiaya.addEventListener('input', function () {
        // Ambil nilai input tanpa titik
        let value = inputBiaya.value.replace(/\./g, '');

        // Pastikan hanya angka yang diterima
        if (!/^\d*$/.test(value)) {
            value = value.replace(/\D/g, '');
        }

        // Format ulang dengan titik setiap tiga digit
        const formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Tampilkan nilai terformat di input visible
        inputBiaya.value = formatted;

        // Simpan nilai asli tanpa titik di hidden input
        hiddenBiaya.value = value;
    });
</script>
@endpush
@endsection