<div>
    @section('linkLatest')
    <div wire:loading>
        Saving post...
    </div>
    @endsection
    {{-- ============================== Create ================================= --}}
    @if ($page == 'index')
    <div class="row">
        <div class="d-flex justify-content-between pb-3">
            <div>
                <label for="">Page : </label>
                <select wire:model.live="paginate" id="">
                    <option value="1">1</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="40">40</option>
                    <option value="60">60</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="right">
                <a wire:click='$set("page", "create")' class="btn btn-primary mx-2">Create new Kelas</a>
            </div>
        </div>
        {{-- <caption>List of users staf</caption> --}}
        <table class="table table-dark">
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
                @forelse ($kelass as $key => $kelas)
                <tr>
                    <th scope="row">{{ $kelass->firstItem() + $key }}</th>
                    <td>{{ $kelas->name }}</td>
                    <td>{{ $kelas->tahun_ajar }}</td>
                    <td>{{ $kelas->description }}</td>
                    <td>
                        <a wire:click='show({{$kelas->id}})' class="btn btn-info">Show</a>
                        <a wire:click='edit({{$kelas->id}})' class="btn btn-primary">Edit</a>
                        <a class="btn btn-danger" data-toggle="modal" data-target="#deleteKelas{{$kelas->id}}">Delete</a>
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
                                    <button type="submit" class="btn btn-danger" data-dismiss="modal"
                                        wire:click='delete({{$kelas->id}})'>Delete {{ $kelas->name
                                        }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr class="text-center">
                    <td colspan="8">Tidak ada data terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="text-center">
            {{ $kelass->links() }}
        </div>
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
</div>