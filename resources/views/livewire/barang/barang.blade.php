@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Barang Management</li>
<li class="breadcrumb-item active">Barang</li>
@section('action')
@can('create barang')
<a href="{{route('barang.create')}}" class="btn btn-outline-primary">Create</a>
@endcan
@endsection
@endsection
<div>
    <div class="row">
        {{-- ============================ Index ====================================== --}}
        @if ($page == 'index')
        <div class="table-responsive">
            <table class="table table-bordered dataTableResponsive">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Category</th>
                        {{-- <th scope="col">Sumber Dana</th>
                        <th scope="col">Tahun Pengadaan</th>
                        <th scope="col">Deskripsi</th> --}}
                        <th scope="col">Total Barang</th>
                        <th scope="col">Foto Barang</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $key => $barang)
                    <tr>
                        <th class="align-middle" scope="row">{{ $key + 1 }}</th>
                        <td class="align-middle">{{ $barang->nama_barang }}</td>
                        <td class="align-middle">{{ $barang->category->name }}</td>
                        {{-- <td class="align-middle">{{ $barang->sumber_dana }}</td>
                        <td class="align-middle">{{ $barang->tahun_pengadaan }}</td>
                        <td class="align-middle">{{ $barang->deskripsi }}</td> --}}
                        <td class="align-middle">{{ $barang->total_barang }}</td>
                        <td>
                            <a data-toggle="modal" data-target="#showImage{{$barang->id}}" class="btn btn-info">View
                                Images</a>
                            {{-- <img src="{{asset($barang->foto_barang)}}" alt="foto barang"
                                class="img-fluid img-thumbnail cursor-pointer"
                                style="width: 50px; height: 50px; cursor: pointer;" data-toggle="modal"
                                data-target="#showImage{{$barang->id}}"> --}}
                        </td>
                        <td class="align-middle">
                            @can('show barang')
                            <a wire:click='show({{$barang->id}})' class="btn btn-info">Show</a>
                            @endcan
                            @can('update barang')
                            <a wire:click='edit({{$barang->id}})' class="btn btn-primary">Update</a>
                            @endcan
                            @can('delete barang')
                            <a class="btn btn-danger m-1" data-toggle="modal"
                                data-target="#deletebarang{{$barang->id}}">Delete</a>
                            @endcan
                        </td>
                    </tr>

                    {{-- Delete Barang --}}
                    <div class="modal fade" id="deletebarang{{$barang->id}}" tabindex="-1"
                        aria-labelledby="deletebarangLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="deletebarangLabel">Delete Barang 
                                        {{$barang->nama_barang}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger"
                                        wire:click='deleteBarang({{$barang->id}})' data-dismiss="modal">Delete
                                        {{$barang->nama_barang}}</button>
                                </div>
                            </div>
                        </div>
                    </div>

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
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- ================================== Create =================================== --}}
        @if ($page == 'create')
        <div class="d-flex bg-secondary p-2 my-2 rounded">
            <a wire:click='$set("page", "import")' class="btn btn-info mx-2">Import Kelas</a>
            <div class="ml-auto">
                <a wire:click='back' class="btn btn-primary my-2 p-2">Back</a>
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
                    <textarea name="deskripsi" id="deskripsiBarang" class="form-control" cols="30" rows="10"></textarea>
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
                    placeholder="Contoh: 2024" title="Masukkan 4 digit tahun, contoh: 2024" required
                    value="{{$barang->tahun_pengadaan}}">
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