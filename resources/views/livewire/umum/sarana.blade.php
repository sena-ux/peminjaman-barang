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
                @if ($saranas->count() >= 10)
                <label for="">Page : </label>
                <select wire:model.live="paginate" id="">
                    <option value="10">10</option>
                    @if ($saranas->count() >= 20)
                    <option value="20">20</option>
                    @endif
                </select>
                @endif
            </div>
            <div class="right">
                <a wire:click='$set("page", "create")' class="btn btn-primary mx-2">Create new Sarana</a>
            </div>
        </div>
        {{-- <caption>List of users staf</caption> --}}
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Sarana</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($saranas as $key => $sarana)
                <tr>
                    <th scope="row">{{ $saranas->firstItem() + $key }}</th>
                    <td>{{ $sarana->nama_sarana }}</td>
                    <td>{{ $sarana->lokasi }}</td>
                    <td>{{ $sarana->keterangan }}</td>
                    <td>
                        <a wire:click='show({{$sarana->id}})' class="btn btn-info">Show</a>
                        <a wire:click='edit({{$sarana->id}})' class="btn btn-primary">Edit</a>
                        <a class="btn btn-danger" data-toggle="modal" data-target="#deletesarana{{$sarana->id}}">Delete</a>
                    </td>
                </tr>

                <!-- Modal Delete -->
                <div class="modal fade" id="deletesarana{{$sarana->id}}" tabindex="-1" aria-labelledby="deletesaranaLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger" id="deletesaranaLabel">Yakin delete sarana dengan
                                    Name : {{ $sarana->nama_sarana }}</h5>
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
                                        wire:click.prevent='delete({{$sarana->id}})' data-dismiss="modal">Delete {{
                                        $sarana->nama_sarana
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
            {{ $saranas->links() }}
        </div>
    </div>
    @endif

    {{-- ======================================= Create ================================== --}}
    @if ($page == 'create')
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h3 class="text-bold mt-auto pt-auto">Create New Sarana</h3>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='store'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" nama_sarana") is-invalid @enderror" id="nama_sarana"
                placeholder="Contoh : Ac, Listrik, Komputer, Gedung TU" value="{{ old('nama_sarana') }}"
                wire:model="nama_sarana" required>
            <label for="nama_sarana" class="required">Nama Sarana</label>
            @error('nama_sarana')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="lokasi" id="lokasi" wire:model="lokasi"
                value="{{ old('lokasi') }}" required>
            <label for="lokasi" class="required">Lokasi</label>
            @error('lokasi')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" wire:model="keterangan" id="keterangan" style="height: 100px"></textarea>
            <label for="keterangan">Keterangan</label>
            @error('keterangan')
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
                <button type="submit" class="btn btn-primary">Create & Other Sarana</button>
            </div>
        </div>
    </form>
    @endif

    {{-- ================================= Show ======================================= --}}
    @if ($page == 'show')
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h5 class="text-bold mt-auto pt-auto">Show Sarana</h5>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <div class="table-responsive">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">Nama Sarana</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $nama_sarana }}</td>
                    <td>{{ $lokasi }}</td>
                    <td>{{ $keterangan }}</td>
                    <td>
                        <a wire:click='$set("page", "edit")' class="btn btn-primary">Update</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    {{-- ======================================= Update ================================== --}}
    @if ($page == "edit")
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h3 class="text-bold mt-auto pt-auto">Update Sarana</h3>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='update({{ $sarana_id }})'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" nama_sarana") is-invalid @enderror" id="nama_sarana"
                placeholder="Contoh : Ac, Listrik, Komputer, Gedung TU" value="{{ old('nama_sarana') }}"
                wire:model="nama_sarana" required>
            <label for="nama_sarana" class="required">Nama Sarana</label>
            @error('nama_sarana')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="lokasi" id="lokasi" wire:model="lokasi"
                value="{{ old('lokasi') }}" required>
            <label for="lokasi" class="required">Lokasi</label>
            @error('lokasi')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" wire:model="keterangan" id="keterangan" style="height: 100px"></textarea>
            <label for="keterangan">Keterangan</label>
            @error('keterangan')
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
                <button type="submit" class="btn btn-primary">Update Sarana</button>
            </div>
        </div>
    </form>
    @endif
</div>