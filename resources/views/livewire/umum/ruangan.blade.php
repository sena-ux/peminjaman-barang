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
                <a wire:click='$set("page", "create")' class="btn btn-primary mx-2">Create new Ruangan</a>
            </div>
        </div>
        {{-- <caption>List of users staf</caption> --}}
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Ruangan</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ruangans as $key => $ruangan)
                <tr>
                    <th scope="row">{{ $ruangans->firstItem() + $key }}</th>
                    <td>{{ $ruangan->nama_ruangan }}</td>
                    <td>{{ $ruangan->lokasi }}</td>
                    <td>
                        <a wire:click='show({{$ruangan->id}})' class="btn btn-info">Show</a>
                        <a wire:click='edit({{$ruangan->id}})' class="btn btn-primary">Edit</a>
                        <a class="btn btn-danger" data-toggle="modal" data-target="#deleteRuangan{{$ruangan->id}}">Delete</a>
                    </td>
                </tr>

                <!-- Modal Delete -->
                <div class="modal fade" id="deleteRuangan{{$ruangan->id}}" tabindex="-1" aria-labelledby="deleteRuanganLabel"
                    aria-hidden="true">
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
                                        wire:click.prevent='delete({{$ruangan->id}})' data-dismiss="modal">Delete {{ $ruangan->nama_ruangan
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
            {{ $ruangans->links() }}
        </div>
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
</div>