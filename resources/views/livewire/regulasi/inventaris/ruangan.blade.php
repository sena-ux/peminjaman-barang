<div>
    @if ($page == 'index')
    <div class="card card-default color-palette-box p-3 table-responsive">
        <div class="row">
            {{-- ============================ Index ====================================== --}}
            <div class="table-responsive">
                <table class="table table-bordered dataTableResponsive">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Ruangan</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Kode Ruangan</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ruangans as $key => $inventarisRuangan)
                        <tr>
                            <th class="align-middle" scope="row">{{ $key + 1 }}</th>
                            <td class="align-middle">{{ $inventarisRuangan->nama_ruangan }}</td>
                            <td class="align-middle">{{ $inventarisRuangan->kelas->name ?? "-" }}</td>
                            <td class="align-middle">{{ $inventarisRuangan->kode_ruangan ?? "-" }}</td>
                            <td class="align-middle">
                                {{-- @can('show inventarisRuangan')
                                <a wire:click='show({{$inventarisRuangan->id}})' class="btn btn-info">Show</a>
                                @endcan
                                @can('update inventarisRuangan')
                                <a wire:click='edit({{$inventarisRuangan->id}})' class="btn btn-primary">Update</a>
                                @endcan
                                @can('delete inventarisRuangan')
                                <a class="btn btn-danger m-1" data-toggle="modal"
                                    data-target="#deleteinventarisRuangan{{$inventarisRuangan->id}}">Delete</a>
                                @endcan --}}
                                @can('insertBarang inventarisRuangan')
                                <a wire:click='insertBarang({{$inventarisRuangan->id}})' class="btn btn-primary">Insert
                                    Barang</a>
                                @endcan
                                @can('cetak inventarisRuangan')
                                <a wire:click='' class="btn btn-success">Cetas Barang</a>
                                @endcan
                            </td>
                        </tr>

                        {{-- Delete inventarisRuangan --}}
                        <div class="modal fade" id="deleteinventarisRuangan{{$inventarisRuangan->id}}" tabindex="-1"
                            aria-labelledby="deleteinventarisRuanganLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger" id="deleteinventarisRuanganLabel">Delete
                                            inventarisRuangan
                                            {{$inventarisRuangan->nama_inventarisRuangan}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            wire:click='deleteinventarisRuangan({{$inventarisRuangan->id}})'
                                            data-dismiss="modal">Delete
                                            {{$inventarisRuangan->nama_inventarisRuangan}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- ================================ SHOW ==================================== --}}
            @if ($page == "show")
            <div class="d-flex bg-secondary p-2 my-2 rounded">
                <div class="ml-auto">
                    <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
                    <a wire:click='edit({{$barang->id}})' class="btn btn-info">Update</a>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 p-2">
                    <label for="namaBarang" class="required">Nama Barang</label>
                    <input type="text" name="name" id="namaBarang" class="form-control" readonly
                        placeholder="Nama Barang : AC Daikin" required value="{{$barang->nama_barang}}">
                </div>
                <div class="col-md-6 p-2">
                    <label for="sumberDana" class="required">Sumber Dana</label>
                    <input type="text" name="sumber_dana" id="sumberDana" class="form-control" readonly
                        placeholder="Sumber Dana : Dana Bos" required value="{{$barang->sumber_dana}}">
                </div>
                <div class="col-md-6 p-2">
                    <label for="tahun_pengadaan" class="required">Tahun Pengadaan</label>
                    <input type="text" name="tahun_pengadaan" id="tahun_pengadaan" class="form-control" readonly
                        placeholder="Contoh: 2024" required value="{{$barang->tahun_pengadaan}}">
                </div>
                <div class="col-md-6 p-2">
                    <label for="harga_barang">Harga Barang</label>
                    <input type="number" name="harga_barang" id="harga_barang" class="form-control" readonly
                        placeholder="Opsional" value="{{$barang->harga}}">
                </div>
                <div class="col-md-6 p-2">
                    <label for="category" class="required">Category</label>
                    <input type="text" class="form-control" readonly value="{{$barang->category->name}}">
                </div>
                <div class="col-md-6 p-2">
                    <label for="total_barang">Total Barang</label>
                    <input type="number" name="total_barang" id="total_barang" class="form-control" readonly
                        value="{{$barang->total_barang}}">
                </div>
                <div class="col-md-6 p-2">
                    <label for="deskripsiBarang">Deskripsi Barang</label>
                    <input type="text" class="form-control" readonly value="{{$barang->deskripsi}}">
                </div>
                <div class="col-md-6 p-2">
                    <label for="foto_barang" class="required">Foto Barang</label>
                    {{-- <input type="file" name="foto_barang" id="foto_barang" class="form-control" readonly
                        placeholder="Upload gambar" accept="png,jpg,jpeg,JPG,PNG,JPEG,gif,GIF" required> --}}
                    <div class="image">
                        <img src="{{asset($barang->foto_barang)}}" alt="Foto Barang" class="img-fluid img-thumbnail">
                    </div>
                </div>
            </div>
            @endif

            {{-- =================================== Edit ==================================== --}}
            @if ($page == "edit")
            <div class="text-end">
                <a wire:click='$set("page", "index")' class="btn btn-primary my-2 p-2">Back</a>
            </div>
            <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-row">
                    <div class="col-md-6 p-2">
                        <label for="namaBarang" class="required">Nama Barang</label>
                        <input type="text" name="name" id="namaBarang" class="form-control"
                            placeholder="Nama Barang : AC Daikin" required value="{{$barang->nama_barang}}">
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="sumberDana">Sumber Dana</label>
                        <input type="text" name="sumber_dana" id="sumberDana" class="form-control"
                            placeholder="Sumber Dana : Dana Bos" value="{{$barang->sumber_dana}}">
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="tahun_pengadaan">Tahun Pengadaan</label>
                        <input type="text" name="tahun_pengadaan" id="tahun_pengadaan" class="form-control"
                            placeholder="Contoh: 2024" title="Masukkan 4 digit tahun, contoh: 2024"
                            value="{{$barang->tahun_pengadaan}}">
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="harga_barang">Harga Barang</label>
                        <input type="number" name="harga_barang" id="harga_barang" class="form-control"
                            placeholder="Opsional" value="{{$barang->harga}}">
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="foto_barang">Foto Barang</label>
                        <input type="file" name="foto_barang" id="foto_barang" class="form-control"
                            placeholder="Upload gambar" accept="png,jpg,jpeg,JPG,PNG,JPEG,gif,GIF">
                        <input type="hidden" name="nama_file_barang" value="{{$barang->foto_barang}}">
                        <div class="p-2">
                            <img src="{{asset($barang->foto_barang)}}" alt="Foto Barang"
                                class="img-fluid img-thumbnail cusor-pointer"
                                style="width: 240px; height: 250px; cursor: pointer;" data-toggle="modal"
                                data-target="#showImage{{$barang->id}}">
                        </div>
                    </div>
                    <div class="col-md-6 p-2">
                        <label for="category" class="required">Select Category</label>
                        <select class="custom-select" name="category" id="category" required>
                            <option value="{{$barang->id_category}}" selected>{{$barang->category->name}}</option>
                            <optgroup label="Categories">
                                @forelse ($categorys as $item)
                                <option value="{{$item->id}}">{{ $item->name }}</option>
                                @empty
                                <option value="" disabled>No Data</option>
                                @endforelse
                            </optgroup>
                        </select>
                    </div>
                    {{-- <div class="col-md-6 p-2">
                        <label for="total_barang">Total Barang</label>
                        <input type="number" name="total_barang" id="total_barang" class="form-control"
                            value="{{$barang->total_barang}}">
                    </div> --}}
                    <div class="col-md-6 p-2">
                        <label for="deskripsiBarang">Deskripsi Barang</label>
                        <textarea name="deskripsi" id="deskripsiBarang" class="form-control" cols="30"
                            rows="10">{{$barang->deskripsi}}</textarea>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Barang</button>
                </div>
            </form>

            <!-- Modal Show Image -->
            <div class="modal fade" id="showImage{{$barang->id}}" data-backdrop="static" data-keyboard="false"
                tabindex="-1" aria-labelledby="showImage{{$barang->id}}Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="showImage{{$barang->id}}Label">Show Image</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{asset($barang->foto_barang)}}" alt="Foto Barang"
                                    class="img-fluid img-thumbnail">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ================================== Create =================================== --}}
    @if ($page == 'insertBarang')
    <div class="card card-default color-palette-box">
        <div class="d-flex p-2 rounded">
            <div class="ml-auto">
                <a wire:click='$set("page", "index")' class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
    <div class="card card-default color-palette-box p-3 table-responsive">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-start bg-success">
                        <span>Create Barang For Ruangan {{$ruangan->nama_ruangan}}</span>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent='insertBarangToRuangan'>
                            <input type="hidden" name="ruangan_id" value="{{$ruangan->id}}">
                            <div class="form-row">
                                <div class="col-md-12 p-2">
                                    <label for="namaBarang" class="required">Nama Barang</label>
                                    <input type="text" wire:model="nama_barang" id="namaBarang" class="form-control"
                                        placeholder="Masukkan nama barang">
                                </div>
                                <div class="col-md-12 p-2 required">
                                    <label for="kode_barang" class="required">Kode Barang</label>
                                    <input type="text" wire:model="kode_barang" id="kode_barang" class="form-control"
                                        placeholder="Masukkan kode barang yang sesuai.">
                                </div>
                                <div class="col-md-12 p-2">
                                    <label for="sumberDana" class="required">Sumber Dana</label>
                                    <input type="text" wire:model="sumber_dana" id="sumberDana" class="form-control"
                                        placeholder="Masukkan sumber dana">
                                </div>
                                <div class="col-md-12 p-2">
                                    <label for="tahun_pengadaan" class="required">Tahun Pengadaan</label>
                                    <input type="number" wire:model="tahun_pengadaan" id="tahun_pengadaan"
                                        class="form-control" placeholder="Masukkan 4 digit tahun, contoh: 2024"
                                        min="1000" max="2099">
                                </div>
                                <div class="col-md-12 p-2">
                                    <label for="seri_pubrik">Seri Pubrik</label>
                                    <input type="text" wire:model="seri_pubrik" id="seri_pubrik" class="form-control"
                                        placeholder="Masukkan nomor seri pubrik yang sesuai.">
                                </div>
                                <div class="col-md-12 p-2">
                                    <label for="ukuran">Ukuran</label>
                                    <input type="text" wire:model="ukuran" id="ukuran" class="form-control"
                                        placeholder="Masukkan ukuran barang yang sesuai">
                                </div>
                                <div class="col-md-12 p-2">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" wire:model="satuan" id="satuan" class="form-control"
                                        placeholder="Masukkan satuan barang yang sesuai">
                                </div>
                                <div class="col-md-12 p-2">
                                    <label for="bahan">Bahan</label>
                                    <input type="text" wire:model="bahan" id="bahan" class="form-control"
                                        placeholder="Masukkan nama bahan yang di gunakan pada barang yang bersangkutan.">
                                </div>
                                <div class="col-md-12 p-2">
                                    <label for="harga_barang">Harga Barang</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="number" class="form-control" id="biaya" aria-describedby="biayaHelp"
                                            required>
                                        <span class="input-group-text">,00</span>
                                    </div>

                                    <input type="hidden" id="biayaHidden" wire:model="harga_barang">
                                </div>
                                <div class="col-md-12 p-2">
                                    <label for="tahun_register">Tahun Register</label>
                                    <input type="number" wire:model="tahun_register" id="tahun_register" class="form-control"
                                        placeholder="Masukkan tahun register barang">
                                </div>
                                <div class="col-md-12 p-2">
                                    <label for="category" class="required">Category</label>
                                    <input type="text" wire:model="category" id="category" class="form-control"
                                        placeholder="Masukkan category name yang sesuai">
                                </div>
                                <div class="col-md-12 p-2">
                                    <label for="deskripsiBarang">Deskripsi Barang</label>
                                    <textarea wire:model="deskripsi" id="deskripsiBarang" cols="30" rows="10" wire:model="deskripsi"
                                        class="form-control"></textarea>
                                </div>
                                <hr>
                                <div class="col-md-12 p-2">
                                    <label for="deskripsiBarang">Keadaan Barang</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group flex-nowrap">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="addon-wrapping">Total</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Username"
                                                    aria-label="Username" aria-describedby="addon-wrapping"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                    wire:model="total_barang" value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group flex-nowrap">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="addon-wrapping">Baik</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Username"
                                                    aria-label="Username" aria-describedby="addon-wrapping"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" wire:model="baik"
                                                    value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group flex-nowrap">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="addon-wrapping">Kurang
                                                        Baik</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Username"
                                                    aria-label="Username" aria-describedby="addon-wrapping"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                    wire:model="kurang_baik" value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group flex-nowrap">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="addon-wrapping">Rusak
                                                        Berat</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Username"
                                                    aria-label="Username" aria-describedby="addon-wrapping"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                    wire:model="rusak_berat" value="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end d-flex justify-content-end">
                                <div class="d-flex align-item-center">
                                    <div class="spinner-border text-primary mr-2" role="status" wire:loading wire:target="store">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Insert Barang For Ruangan
                                        {{$ruangan->nama_ruangan}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-danger"><span>Ketentuan Pengisian Barang</span></div>
                    <div class="card-body">
                        <ol>
                            <li>Yang berisi tanda bintang <span class="text-danger">*</span> tidak boleh di kosongkan
                            </li>
                            <li>Silahkan inputkan kode barang yang sesuai.</li>
                            <li><b>Ingat ini akan menginputkan barang di ruangan yang di pilih saja yaitu Ruangan {{
                                    $ruangan->nama_ruangan }}</b></li>
                            <li>Masukkan Sumber dana yang sesuai dengan barang.</li>
                            <li>
                                <b>Panduan pengisian Category</b>
                                <ul>
                                    <li>Nama category berdasarkan barang</li>
                                    <li>Nama category bersifat menyeluruh pada 1 barang yang sejenis.</li>
                                    <li>Perhatian huruf besar dan huruf kecil saat pembuatan category name.</li>
                                    <li>Contoh :
                                        <ul>
                                            <li>Listrik</li>
                                            <li>Kipas Angin</li>
                                            <li>AC</li>
                                            <li>Komputer</li>
                                            <li>Laptop</li>
                                            <li>Meja</li>
                                            <li>Kursi</li>
                                        </ul>
                                    </li>
                                    <li>Penjelasan singkat : Category ini akan membedakan antara barang kipas angin
                                        dengan yang lain untuk keperluan manajement barang, Berapa barang dengan
                                        category : AC yang ada saat ini.</li>
                                </ul>
                            </li>
                            <li>
                                <b>Kode barang unique di miliki oleh 1 jenis barang.
                                    Misalnya : meja semua meja bisa memiliki kode barang yang sama nanti jumlah barang yang menyesuaikan.
                                </b>
                            </li>
                            <li>
                                <b>Jika barang yang tidak memiliki kode baranng bisa sesuaikan dengan kode barang yang lain yang satu barang.</b>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($page == 'insertFotoBarang')
    <div class="card card-default color-palette-box">
        <div class="row">
            <form action="{{route('inventaris.insert')}}" method="post">
                <div class="col-md-12 p-2">
                    <label for="foto_barang">Foto Barang</label>
                    <input type="file" name="foto_barang" id="foto_barang" class="form-control"
                        placeholder="Upload gambar" accept="image/*" capture>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>