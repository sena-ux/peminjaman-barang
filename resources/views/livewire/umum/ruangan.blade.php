<div>
    @section('linkLatest')
    <div wire:loading>
        Saving post...
    </div>
    @endsection
    {{-- ============================= Import Error ============================ --}}
    @if (session('import_errors'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <div class="alert alert-danger">
            <p>Beberapa baris gagal diimpor:</p>
            <ul>
                @foreach (session('import_errors') as $error)
                <li>
                    Baris {{ $error['row'] ?? 'Tidak diketahui' }}:
                    {{ implode(', ', (array) ($error['error'] ?? 'Kesalahan tidak diketahui')) }}
                </li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    {{-- ============================== Create ================================= --}}
    @if ($page == 'index')
    <div class="row">
        @canany(['import ruangan', 'create ruangan'])
        <div class="d-flex bg-secondary p-2 my-2 rounded">
            @can('import ruangan')
            <a wire:click='$set("page", "import")' class="btn btn-info mx-2">Import Ruangan</a>
            @endcan
            @can('create ruangan')
            <div class="right ml-auto">
                <a wire:click='$set("page", "create")' class="btn btn-primary mx-2">Create new Ruangan</a>
            </div>
            @endcan
        </div>
        @endcanany
        {{-- <caption>List of users staf</caption> --}}
        <table class="table table-dark dataTableResponsive">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Ruangan</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Kode Ruangan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ruangans as $key => $ruangan)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $ruangan->nama_ruangan }}</td>
                    <td>{{ $ruangan->lokasi }}</td>
                    <td>{{ $ruangan->kode_ruangan }}</td>
                    <td>
                        @can('show ruangan')
                        <a wire:click='show({{$ruangan->id}})' class="btn btn-info">Show</a>
                        @endcan
                        @can('update ruangan')
                        <a wire:click='edit({{$ruangan->id}})' class="btn btn-primary">Edit</a>
                        @endcan
                        @can('delete ruangan')
                        <a class="btn btn-danger" data-toggle="modal"
                            data-target="#deleteRuangan{{$ruangan->id}}">Delete</a>
                        @endcan
                    </td>
                </tr>

                <!-- Modal Delete -->
                <div class="modal fade" id="deleteRuangan{{$ruangan->id}}" tabindex="-1"
                    aria-labelledby="deleteRuanganLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger" id="deleteRuanganLabel">Yakin delete Ruangan dengan
                                    Name : {{ $ruangan->nama_ruangan }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer text-end">
                                <div class="d-flex align-item-center">
                                    <div class="spinner-border text-primary mr-2" role="status" wire:loading
                                        wire:target="delete">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <button type="submit" class="btn btn-danger"
                                        wire:click.prevent='delete({{$ruangan->id}})' data-dismiss="modal">Delete {{
                                        $ruangan->nama_ruangan
                                        }}</button>
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

    {{-- ======================================= Create ================================== --}}
    @if ($page == 'create')
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h3 class="text-bold mt-auto pt-auto">Create New Ruangan</h3>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='store'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" nama_ruangan") is-invalid @enderror" id="nama_ruangan"
                placeholder="Contoh : Lab Bahasa" value="{{ old('nama_ruangan') }}" wire:model="nama_ruangan" required>
            <label for="nama_ruangan" class="required">Nama Ruangan</label>
            @error('nama_ruangan')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="lokasi" id="lokasi" wire:model="lokasi"
                value="{{ old('lokasi') }}" required>
            <label for="lokasi">Lokasi</label>
            @error('lokasi')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <select wire:model="kelas_id" id="kelas" class="form-control @error('kelas') is-invalid @enderror">
                <option value="">Select Kelas</option>
                <optgroup label="Kelas">
                    @forelse ($kelas as $item)
                    <option value="{{$item->id}}">{{ $item->name }}</option>
                    @empty
                    <option value="" disabled>Tidak ada data kelas.</option>
                    @endforelse
                </optgroup>
            </select>
            <label for="kelas">Kelas</label>
            <small class="text-secondary">Note : Masukkan kelas jika ada.</small>
            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <button type="reset" class="btn btn-secondary">Reset Form</button>
            <div class="d-flex align-item-center">
                <div class="spinner-border text-primary mr-2" role="status" wire:loading wire:target="store">
                    <span class="sr-only">Loading...</span>
                </div>
                <button type="submit" class="btn btn-primary">Create & Other Ruangan</button>
            </div>
        </div>
    </form>
    @endif


    @if ($page == 'show')
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h5 class="text-bold mt-auto pt-auto">Show Kelas</h5>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <div class="table-responsive">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">Nama Ruangan</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $nama_ruangan }}</td>
                    <td>{{ $lokasi }}</td>
                    <td>
                        <a wire:click='$set("page", "edit")' class="btn btn-primary">Update</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
    @if ($page == "edit")
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h3 class="text-bold mt-auto pt-auto">Update Ruangan</h3>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='update({{ $ruangan_id }})'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" nama_ruangan") is-invalid @enderror" id="nama_ruangan"
                placeholder="Contoh : Lab Bahasa" value="{{ old('nama_ruangan') }}" wire:model="nama_ruangan" required>
            <label for="nama_ruangan" class="required">Nama Ruangan</label>
            @error('nama_ruangan')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="lokasi" id="lokasi" wire:model="lokasi"
                value="{{ old('lokasi') }}" required>
            <label for="lokasi">Lokasi</label>
            @error('lokasi')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <select wire:model="kelas_id" id="kelas" class="form-control @error('kelas') is-invalid @enderror">
                <option value="">Select Kelas</option>
                <optgroup label="Kelas">
                    @forelse ($kelas as $item)
                    <option value="{{$item->id}}">{{ $item->name }}</option>
                    @empty
                    <option value="" disabled>Tidak ada data kelas.</option>
                    @endforelse
                </optgroup>
            </select>
            <label for="kelas">Kelas</label>
            <small class="text-secondary">Note : Masukkan kelas jika ada.</small>
            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <button type="reset" class="btn btn-secondary">Reset Form</button>
            <div class="d-flex align-item-center">
                <div class="spinner-border text-primary mr-2" role="status" wire:loading wire:target="update">
                    <span class="sr-only">Loading...</span>
                </div>
                <button type="submit" class="btn btn-primary">Update Ruangan</button>
            </div>
        </div>
    </form>
    @endif

    {{-- ========================= Import Ruangan ====================== --}}
    @if ($page == "import")
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h6 class="text-bold mt-auto pt-auto">Import Ruangan</h6>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card text-start">
                <div class="card-header">
                    <h5 class="card-title">Untuk import data ruangan silahkan download template import nya <a
                            class="btn btn-primary" wire:click.prevent='downloadTemplate'>Template Import</a></h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('import.ruangan')}}" enctype="multipart/form-data">
                        @method("POST")
                        @csrf
                        <input type="file" name="file" id="importRuangan" class="form-control" accept=".xlsx,.xls">
                        <button type="submit" class="btn btn-primary p-2 my-2">Import Ruangan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-start">
                <div class="card-header">
                    Ketentuan Import Ruangan
                </div>
                <div class="card-body">
                    <ul>
                        <li>Header tolong jangan di hapus yang berapa di baris pertama paling atas</li>
                        <li>Isi mulai dari baris kedua</li>
                        <li>Penulisan Nama Ruangan adalah menggunakan bilangan Kalimat Baku, misalnya : <b>Lab
                                Bahasa</b></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>