<div>
    <div class="row">
        @if ($page == 'index')
        <div class="text-end">
            <a wire:click='create' class="btn btn-primary my-2 p-2">Create Inventory Barang</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Ruangan</th>
                        <th scope="col">Kode Barang</th>
                        <th scope="col">Date</th>
                        <th scope="col">Updated</th>
                        {{-- <th scope="col">Status Barang</th> --}}
                        {{-- <th scope="col">Kondisi Barang</th> --}}
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inventoryBarangs as $key => $inventoryBarang)
                    <tr>
                        <th scope="row">{{ $inventoryBarangs->firstItem() + $key }}</th>
                        <td>{{ $inventoryBarang->barang->nama_barang }}</td>
                        <td>{{ $inventoryBarang->ruangan->nama_ruangan }}</td>
                        <td>{{ $inventoryBarang->kode_barang }}</td>
                        <td>{{ $inventoryBarang->tanggal }}</td>
                        <td>{{ $inventoryBarang->updated_at .' | ' . $inventoryBarang->updated_at->diffForHumans() }}
                        </td>
                        {{-- <td>
                            <p class="badge 
                            {{ $inventoryBarang->status_barang == 'Tersedia' ? 'badge-success' : '' }}
                            {{ $inventoryBarang->status_barang == 'Tidak Tersedia' ? 'badge-danger' : '' }}
                            {{ $inventoryBarang->status_barang == 'Hilang' ? 'badge-danger' : '' }}
                            {{ $inventoryBarang->status_barang == 'Dipinjam' ? 'badge-info' : '' }}
                            {{ $inventoryBarang->status_barang == 'Habis' ? 'badge-warning' : '' }}
                            {{ empty($inventoryBarang->status_barang) ? 'badge-secondary' : '' }}">
                                {{ $inventoryBarang->status_barang }}
                            </p>
                        </td>
                        <td>
                            <p class="badge 
                            {{ $inventoryBarang->kondisi == 'Bagus' ? 'badge-success' : '' }}
                            {{ $inventoryBarang->kondisi == 'Rusak' ? 'badge-danger' : '' }}
                            {{ $inventoryBarang->kondisi == 'Layak Dipakai' ? 'badge-danger' : '' }}
                            {{ $inventoryBarang->kondisi == 'Tidak Layak Dipakai' ? 'badge-info' : '' }}
                            {{ $inventoryBarang->kondisi == 'Rusak Parah' ? 'badge-warning' : '' }}
                            {{ $inventoryBarang->kondisi == 'Baru' ? 'badge-warning' : '' }}
                            {{ empty($inventoryBarang->kondisi) ? 'badge-secondary' : '' }}">
                                {{ $inventoryBarang->kondisi }}
                            </p>
                        </td> --}}
                        <td>
                            <a wire:click='show({{$inventoryBarang->id}})' class="btn btn-info">Show</a>
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center">
                        <td colspan="9">Saat ini belum ada data inventory barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif
        @if ($page == 'create')
        <div class="text-end">
            <a wire:click='back' class="btn btn-primary my-2 p-2">Back</a>
        </div>
        <form wire:submit.prevent='store'>
            <div class="form-row">
                <div class="col-md-6 p-2">
                    <label for="barang" class="required">Barang</label>
                    <select class="custom-select" wire:model="barang" id="barang" required>
                        <option value="" selected>Open this select Barang</option>
                        <optgroup label="List Barang">
                            @forelse ($dataBarang as $item)
                            <option value="{{$item->id}}">{{ $item->nama_barang }}</option>
                            @empty
                            <option value="" disabled>No Data</option>
                            @endforelse
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-6 p-2">
                    <label for="ruangan" class="required">Ruangan</label>
                    <select class="custom-select" wire:model="ruangan" id="ruangan" required>
                        <option value="" selected>Open this select Ruangan</option>
                        <optgroup label="List Ruangan">
                            @forelse ($dataRuangan as $item)
                            <option value="{{$item->id}}">{{ $item->nama_ruangan }}</option>
                            @empty
                            <option value="" disabled>No Data</option>
                            @endforelse
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-6 p-2">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" wire:model="kode_barang" id="kode_barang" class="form-control"
                        placeholder="Kode Barang" aria-describedby="kode_barang">
                    <small id="kode_barang" class="form-text text-muted">
                        Penting: Jika Kode Barang kosong maka aplikasi akan generate Kode Barang secara acak
                    </small>
                </div>
                <div class="col-md-6 p-2">
                    <label for="date">Tanggal</label>
                    <input type="date" wire:model="date" id="date" class="form-control" placeholder="Kode Barang"
                        aria-describedby="date">
                </div>
                {{-- <div class="col-md-6 p-2">
                    <label for="kondisi" class="required">Kondisi</label>
                    <select class="custom-select" wire:model="kondisiData" id="kondisi" required>
                        <option value="" selected>Open this select Kondisi</option>
                        <optgroup label="List Kondisi">
                            @forelse ($kondisi as $item)
                            <option value="{{$item['name']}}">{{ $item['name'] }}</option>
                            @empty
                            <option value="" disabled>No Data</option>
                            @endforelse
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-6 p-2">
                    <label for="status" class="required">Status</label>
                    <select class="custom-select" wire:model="statusData" id="status" required>
                        <option value="" selected>Open this select Status</option>
                        <optgroup label="List Ststuas">
                            @forelse ($status as $item)
                            <option value="{{$item['name']}}">{{ $item['name'] }}</option>
                            @empty
                            <option value="" disabled>No Data</option>
                            @endforelse
                        </optgroup>
                    </select>
                </div> --}}
            </div>
            <div class="d-flex justify-content-between">
                <button type="reset" class="btn btn-secondary">Reset Form</button>
                <div class="d-flex align-item-center">
                    <div class="spinner-border text-primary mr-2" role="status" wire:loading wire:target="store">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <button type="submit" class="btn btn-primary">Create & Other Inventory Barang</button>
                </div>
            </div>
        </form>
        @endif

        {{-- ================================ SHOW ==================================== --}}
        @if ($page == "show")
        {{-- <div class="text-end">
            <a wire:click='create' class="btn btn-primary my-2 p-2">Update Inventory Barang</a>
        </div> --}}
        <div class="table-responsive border-bottom border-light">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Ruangan</th>
                        <th scope="col">Kode Barang</th>
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $barang }}</td>
                        <td>{{ $ruangan }}</td>
                        <td>{{ $kode_barang }}</td>
                        <td>{{ $date }}
                        </td>
                        <td>{{ $updated_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-end py-2">
            <a data-toggle="modal" data-target="#create-kondisi-barang" class="btn btn-primary">Create Kondisi
                Barang</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Kondisi</th>
                        <th scope="col">Status Barang</th>
                        <th scope="col">Images</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kondisiBarang as $item)
                    <tr>
                        <td class="align-middle">{{ $item->date }}</td>
                        <td class="align-middle">{{ $item->kondisi }}</td>
                        <td class="align-middle">{{ $item->status_barang }}</td>
                        <td>
                            <a data-bs-toggle="modal" data-bs-target="#showImages{{$item->id}}">
                                <img src="{{ asset('uploads/kondisiBarang/' . $item->images ) }}" class="img-thumbnail"
                                    style="width: 80px; height: 80px;" alt="Image Kondisi Barang" srcset="">
                            </a>
                        </td>
                        <td class="align-middle">
                            {{-- <a class="btn btn-info m-1" data-toggle="modal"
                                data-target="#edit-kondisi-barang">Edit</a> --}}
                            <a class="btn btn-danger m-1" data-toggle="modal"
                                data-target="#delete-kondisi-barang">Delete</a>
                        </td>
                    </tr>

                    <!-- Modal Show Images -->
                    <div class="modal fade" id="showImages{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="showImages{{$item->id}}Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showImages{{$item->id}}Label">Show Images</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="{{ asset('uploads/kondisiBarang/' . $item->images ) }}" alt="Show images" srcset="" class="img-fluid img-thumbnail">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Create Kondisi Barang -->
                    <div class="modal fade" id="delete-kondisi-barang" tabindex="-1"
                        aria-labelledby="delete-kondisi-barangLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="delete-kondisi-barangLabel">Delete Kondisi
                                        {{$item->inventory->barang->nama_barang}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger"
                                        wire:click='deleteKondisi({{$item->id}})' data-dismiss="modal">Delete
                                        Kondisi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr class="text-center">
                        <td colspan="7">Tidak ada data kondisi barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif

        <!-- Modal Create Kondisi Barang -->
        <div class="modal fade" id="create-kondisi-barang" tabindex="-1" aria-labelledby="create-kondisi-barangLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="create-kondisi-barangLabel">Create New Kondisi {{$barang}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('create-kondisi-barang')}}" method="post" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="row">
                                <input type="hidden" name="inv_brg_id" value="{{$inv_brg_id}}">
                                <div class="col-md-6 p-2">
                                    <label for="date">Tanggal</label>
                                    <input type="date" name="date" id="date" class="form-control">
                                </div>
                                <div class="col-md-6 p-2">
                                    <label for="kondisi" class="required">Kondisi</label>
                                    <select class="custom-select" name="kondisi" id="kondisi" required>
                                        <option value="" selected>Open this select Kondisi</option>
                                        <optgroup label="List Kondisi">
                                            @forelse ($kondisi as $item)
                                            <option value="{{$item['name']}}">{{ $item['name'] }}</option>
                                            @empty
                                            <option value="" disabled>No Data</option>
                                            @endforelse
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-6 p-2">
                                    <label for="status" class="required">Status</label>
                                    <select class="custom-select" name="status" id="status" required>
                                        <option value="" selected>Open this select Status</option>
                                        <optgroup label="List Ststuas">
                                            @forelse ($status as $item)
                                            <option value="{{$item['name']}}">{{ $item['name'] }}</option>
                                            @empty
                                            <option value="" disabled>No Data</option>
                                            @endforelse
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-6 p-2">
                                    <label for="images" class="required">Upload Images</label>
                                    <input type="file" name="images" id="images" class="form-control"
                                        accept=".png,.jpg,.jpeg">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="create-kondisi" hidden></button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"
                            onclick="document.getElementById('create-kondisi').click()">Create New Kondisi</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Update Kondisi Barang -->
        <div class="modal fade" id="edit-kondisi-barang" tabindex="-1" aria-labelledby="edit-kondisi-barangLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="edit-kondisi-barangLabel">Delete Kondisi
                            {{$barang}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('create-kondisi-barang')}}" method="post" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="row">
                                <input type="hidden" name="inv_brg_id" value="{{$inv_brg_id}}">
                                <div class="col-md-6 p-2">
                                    <label for="date">Tanggal</label>
                                    <input type="date" name="date" id="date" class="form-control">
                                </div>
                                <div class="col-md-6 p-2">
                                    <label for="kondisi" class="required">Kondisi</label>
                                    <select class="custom-select" name="kondisi" id="kondisi" required>
                                        <option value="" selected>Open this select Kondisi</option>
                                        <optgroup label="List Kondisi">
                                            @forelse ($kondisi as $item)
                                            <option value="{{$item['name']}}">{{ $item['name'] }}</option>
                                            @empty
                                            <option value="" disabled>No Data</option>
                                            @endforelse
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-6 p-2">
                                    <label for="status" class="required">Status</label>
                                    <select class="custom-select" name="status" id="status" required>
                                        <option value="" selected>Open this select Status</option>
                                        <optgroup label="List Ststuas">
                                            @forelse ($status as $item)
                                            <option value="{{$item['name']}}">{{ $item['name'] }}</option>
                                            @empty
                                            <option value="" disabled>No Data</option>
                                            @endforelse
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-6 p-2">
                                    <label for="images" class="required">Upload Images</label>
                                    <input type="file" name="images" id="images" class="form-control"
                                        accept=".png,.jpg,.jpeg">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="create-kondisi" hidden></button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Delete
                            Kondisi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>