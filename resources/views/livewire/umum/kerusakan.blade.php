@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Barang Management</li>
<li class="breadcrumb-item active">Barang</li>
@section('action')
@can('create kerusakan')
<a href="{{route('kerusakan.create')}}" class="btn btn-outline-primary">Create</a>
@endcan
@endsection
@endsection
<div>
    <div class="row">
        {{-- ============================ Index ====================================== --}}
        @if ($page == 'index')
        {{-- <div class="d-flex bg-secondary p-2 my-2 rounded">
            <div class="ml-auto">
                <a wire:click='$set("page", "create")' class="btn btn-primary">Create</a>
            </div>
        </div> --}}
        <div class="table-responsive">
            <table class="table table-bordered dataTableResponsive">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Pelapor</th>
                        <th scope="col">Judul Kerusakan</th>
                        <th scope="col">Tingkat Kerusakan</th>
                        <th scope="col">Status</th>
                        @can('show kerusakan')
                        <th scope="col">Detail Kerusakan</th>
                        @endcan
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kerusakans as $key => $kerusakan)
                    <tr>
                        <th class="align-middle" scope="row">{{ $key + 1 }}</th>
                        <td class="align-middle">{{ $kerusakan->name }}</td>
                        <td class="align-middle">{{ $kerusakan->name }}</td>
                        <td class="align-middle">{{ $kerusakan->tingkat_kerusakan }}</td>
                        <td class="align-middle">
                            <p class="badge p-1 
                            {{ $kerusakan->status == 'validasi' ? 'badge-warning' : '' }}
                            {{ $kerusakan->status == 'proses' ? 'badge-info' : '' }}
                            {{ $kerusakan->status == 'error' ? 'badge-danger' : '' }}
                            {{ $kerusakan->status == 'selesai' ? 'badge-success' : '' }}
                            {{ $kerusakan->status == 'pending' ? 'badge-warning' : '' }}
                            {{ empty($kerusakan->status) ? 'badge-secondary' : '' }}">
                                {{ $kerusakan->status ?? "No Data" }}
                            </p>
                        </td>
                        @can('show kerusakan')
                        <td class="align-middle">
                            <a wire:click='show({{$kerusakan->id}})' class="btn btn-info">Show</a>
                        </td>
                        @endcan
                        <td class="align-middle">
                            @can('edit kerusakan')
                            <a href="{{route("kerusakan.edit", $kerusakan->id)}}" class="btn btn-primary">Update</a>
                            @elsecan('delete kerusakan')
                            <a class="btn btn-danger m-1" data-toggle="modal"
                                data-target="#deletekerusakan{{$kerusakan->id}}">Delete</a>
                            @endcan
                        </td>
                    </tr>

                    {{-- Delete kerusakan --}}
                    <div class="modal fade" id="deletekerusakan{{$kerusakan->id}}" tabindex="-1"
                        aria-labelledby="deletekerusakanLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="deletekerusakanLabel">Delete kerusakan
                                        {{$kerusakan->name}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger"
                                        wire:click='deleteKerusakan({{$kerusakan->id}})' data-dismiss="modal">Delete
                                        {{$kerusakan->name}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- ================================== Create =================================== --}}
        @if ($page == 'create')
        <div class="d-flex bg-secondary p-2 my-2 rounded">
            <div class="ml-auto">
                <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
            </div>
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
                    <label for="total_barang">Total Barang</label>
                    <input type="number" name="total_barang" id="total_barang" class="form-control">
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Create & Other Barang</button>
            </div>
        </form>
        @endif

        {{-- ================================ SHOW ==================================== --}}
        @if ($page == "show")
        <div class="d-flex bg-secondary p-2 my-2 rounded">
            <div class="ml-auto">
                <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
                <a href="{{route("kerusakan.edit", $kerusakan->id)}}" class="btn btn-info">Update</a>
            </div>
        </div>
        <div class="row">
            {!! $kerusakan->detail_kerusakan !!}
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
                    <label for="sumberDana" class="required">Sumber Dana</label>
                    <input type="text" name="sumber_dana" id="sumberDana" class="form-control"
                        placeholder="Sumber Dana : Dana Bos" required value="{{$barang->sumber_dana}}">
                </div>
                <div class="col-md-6 p-2">
                    <label for="tahun_pengadaan" class="required">Tahun Pengadaan</label>
                    <input type="text" name="tahun_pengadaan" id="tahun_pengadaan" class="form-control"
                        placeholder="Contoh: 2024" title="Masukkan 4 digit tahun, contoh: 2024" required
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
        <div class="modal fade" id="showImage{{$barang->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="showImage{{$barang->id}}Label" aria-hidden="true">
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
        @endif
    </div>
</div>