<div>
    @section('linkLatest')
    <div wire:loading>
        Saving post...
    </div>
    @endsection
    {{-- ============================== Create ================================= --}}
    @if ($page == 'index')
    <div class="row">
        @canany(['import kelas', 'create kelas'])
        <div class="d-flex bg-secondary p-2 my-2 rounded">
            @can('import kelas')
            <a wire:click='$set("page", "import")' class="btn btn-info mx-2">Import Kelas</a>
            @endcan
            @can('create kelas')
            <div class="ml-auto">
                <a wire:click='$set("page", "create")' class="btn btn-primary mx-2">Create new Kelas</a>
            </div>
            @endcan
        </div>
        @endcanany
        {{-- <caption>List of users staf</caption> --}}
        <table class="table table-dark dataTableResponsive">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Kelas</th>
                    <th scope="col">Tahun Pelajaran</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelass as $key => $kelas)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $kelas->name }}</td>
                    <td>{{ $kelas->tahun_ajar }}</td>
                    <td>{{ $kelas->description }}</td>
                    <td>
                        @can('show kelas')
                        <a wire:click='show({{$kelas->id}})' class="btn btn-info">Show</a>
                        @endcan
                        @can('update kelas')
                        <a wire:click='edit({{$kelas->id}})' class="btn btn-primary">Edit</a>
                        @endcan
                        @can('delete kelas')
                        <a class="btn btn-danger" data-toggle="modal"
                            data-target="#deleteKelas{{$kelas->id}}">Delete</a>
                        @endcan
                    </td>
                </tr>

                <!-- Modal Delete -->
                <div class="modal fade" id="deleteKelas{{$kelas->id}}" tabindex="-1" aria-labelledby="deleteKelasLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger" id="deleteKelasLabel">Yakin delete Kelas dengan
                                    Name : {{ $kelas->name }}</h5>
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
                                    <button type="submit" class="btn btn-danger text-center" data-dismiss="modal"
                                        wire:click='delete({{$kelas->id}})'>Delete {{ $kelas->name
                                        }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        {{-- <div class="text-center">
            {{ $kelass->links() }}
        </div> --}}
    </div>
    @endif

    {{-- ======================================= Create ================================== --}}
    @if ($page == 'create')
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h3 class="text-bold mt-auto pt-auto">Create New Kelas</h3>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='store'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" name") is-invalid @enderror" id="name"
                placeholder="Contoh : Lab Bahasa" value="{{ old('name') }}" wire:model="name" required>
            <label for="name" class="required">Nama Kelas</label>
            @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" tahun_ajar") is-invalid @enderror" placeholder="tahun_ajar"
                id="tahun_ajar" wire:model="tahun_ajar" value="{{ old('tahun_ajar') }}" required>
            <label for="tahun_ajar" class="required">Tahun Pelajaran Aktif</label>
            <small class="text-secondary">Note : Masukkan Tahun pelajaran yang aktif saat ini.</small>
            @error('tahun_ajar')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" description") is-invalid @enderror"
                placeholder="description" id="description" wire:model="description" value="{{ old('description') }}"
                required>
            <label for="kelas" class="required">Keterangan</label>
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
                <button type="submit" class="btn btn-primary">Create & Other Kelas</button>
            </div>
        </div>
    </form>
    @endif

    {{-- ================================= Show =================================== --}}
    @if ($page == 'show')
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h5 class="text-bold mt-auto pt-auto">Show Kelas</h5>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <div class="table-responsive">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">Nama Kelas</th>
                    <th scope="col">Tahun Pelajaran</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $name }}</td>
                    <td>{{ $tahun_ajar }}</td>
                    <td>{{ $description }}</td>
                    <td>
                        <a wire:click='$set("page", "edit")' class="btn btn-primary">Update</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    {{-- =============================== Update ============================== --}}
    @if ($page == "edit")
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h3 class="text-bold mt-auto pt-auto">Update Kelas</h3>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='update({{ $id_kelas }})'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" name") is-invalid @enderror" id="name"
                placeholder="Contoh : Lab Bahasa" value="{{ old('name') }}" wire:model="name" required>
            <label for="name" class="required">Nama Kelas</label>
            @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" tahun_ajar") is-invalid @enderror" placeholder="tahun_ajar"
                id="tahun_ajar" wire:model="tahun_ajar" value="{{ old('tahun_ajar') }}" required>
            <label for="tahun_ajar" class="required">Tahun Pelajaran Aktif</label>
            <small class="text-secondary">Note : Masukkan Tahun pelajaran yang aktif saat ini.</small>
            @error('tahun_ajar')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" description") is-invalid @enderror"
                placeholder="description" id="description" wire:model="description" value="{{ old('description') }}"
                required>
            <label for="kelas" class="required">Keterangan</label>
            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="text-end">
            <div class="d-flex align-item-center justify-content-end">
                <div class="spinner-border text-primary mr-2" role="status" wire:loading wire:target="update">
                    <span class="sr-only">Loading...</span>
                </div>
                <button type="submit" class="btn btn-primary">Update Kelas</button>
            </div>
        </div>
    </form>
    @endif

    {{-- ========================= Import Kelas ====================== --}}
    @if ($page == "import")
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h6 class="text-bold mt-auto pt-auto">Import Kelas</h6>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card text-start">
                <div class="card-header">
                    <h5 class="card-title">Untuk import data kelas silahkan download template import nya <a
                            class="btn btn-primary" wire:click.prevent='downloadTemplate'>Template Import</a></h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('import.kelas')}}" enctype="multipart/form-data">
                        @method("POST")
                        @csrf
                        <input type="file" name="file" id="importkelas" class="form-control" accept=".xlsx,.xls">
                        <button type="submit" class="btn btn-primary p-2 my-2">Import Kelas</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-start">
                <div class="card-header">
                    Ketentuan Import Kelas
                </div>
                <div class="card-body">
                    <ul>
                        <li>Header tolong jangan di hapus yang berapa di baris pertama paling atas</li>
                        <li>Isi mulai dari baris kedua</li>
                        <li>Penulihan Tahun Pelajaran wajib menggunakan bilangan numeric, seperti : <b>2024</b></li>
                        <li>Penulisan kelas adalah menggunakan bilangan romawi, misalnya : <b>X.1</b></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>