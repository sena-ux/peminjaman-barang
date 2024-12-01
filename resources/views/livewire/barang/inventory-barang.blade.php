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
                        <th scope="col">Status Barang</th>
                        <th scope="col">Kondisi Barang</th>
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
                        <td>
                            <p class="badge 
                            {{ $inventoryBarang->status_barang == 'Tersedia' ? 'badge-success' : '' }}
                            {{ $inventoryBarang->status_barang == 'Tidak Tersedia' ? 'badge-danger' : '' }}
                            {{ $inventoryBarang->status_barang == 'Hilang' ? 'badge-danger' : '' }}
                            {{ $inventoryBarang->status_barang == 'Dipinjam' ? 'badge-info' : '' }}
                            {{ $inventoryBarang->status_barang == 'Habis' ? 'badge-warning' : '' }}
                            {{ empty($inventoryBarang->status_barang) ? 'badge-secondary' : '' }}">
                                {{ $inventoryBarang->status_barang ?? "No Data" }}
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
                                {{ $inventoryBarang->kondisi ?? "No Data" }}
                            </p>
                        </td>
                        <td>
                            <a wire:click='show({{$inventoryBarang->id}})' class="btn btn-info">Show</a>
                            <a wire:click='edit({{$inventoryBarang->id}})' class="btn btn-primary">Edit</a>
                            <a class="btn btn-danger m-1" data-toggle="modal"
                                data-target="#deleteInventoryBarang{{$inventoryBarang->id}}">Delete</a>
                        </td>
                    </tr>
                    {{-- Delete Inventory --}}
                    <div class="modal fade" id="deleteInventoryBarang{{$inventoryBarang->id}}" tabindex="-1"
                        aria-labelledby="deleteInventoryBarangLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="deleteInventoryBarangLabel">Delete Inventory
                                        {{$inventoryBarang->kode_barang}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger"
                                        wire:click='deleteInventory({{$inventoryBarang->id}})'
                                        data-dismiss="modal">Delete
                                        {{$inventoryBarang->kode_barang}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <label for="date">Tanggal</label>
                    <input type="date" wire:model="date" id="date" class="form-control" placeholder="Kode Barang"
                        aria-describedby="date">
                </div>
                {{-- <div class="col-md-6 p-2">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" wire:model="kode_barang" id="kode_barang" class="form-control"
                        placeholder="Kode Barang" aria-describedby="kode_barang">
                    <small id="kode_barang" class="form-text text-muted">
                        Penting: Jika Kode Barang kosong maka aplikasi akan generate Kode Barang secara acak
                    </small>
                </div> --}}
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
                <div class="col-md-6 p-2" id="jumlah">
                    <label for="jumlah_barang">Jumlah Barang</label>
                    <input type="number" wire:model="jumlah_barang" id="jumlah_barang" class="form-control"
                        placeholder="Masukkan Jumlah Barang" aria-describedby="jumlah_barang">
                    <small id="jumlah_barang" class="form-text text-muted">
                        Penting: Jika ini barang alat kebersihan seperti sapu silahkan masukkan perkelas ada berapa
                        sapunya.
                    </small>
                </div>
                <div class="col-md-12 p-2">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1"
                            wire:model='alatKebersihan'>
                        <label class="custom-control-label" for="customSwitch1">Check toggle untuk mengaktifkan mode
                            insert inventory barang alat kebersihan.</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route("barang.index") }}" class="btn btn-secondary">Create Barang</a>
                <div class="d-flex align-item-center">
                    <div class="spinner-border text-primary mr-2" role="status" wire:loading wire:target="store">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <button type="submit" class="btn btn-primary">Create & Other Inventory Barang</button>
                </div>
            </div>
        </form>
        @endif

        {{-- ======================================= Edit Inventory ============================= --}}
        @if ($page == 'edit')
        <div class="text-end">
            <a wire:click='show({{$inventoryBarang->id}})' class="btn btn-secondary">Show Inventory Barang</a>
        </div>
        <form wire:submit.prevent='update({{$inventoryBarang->id}})'>
            <div class="form-row">
                <div class="col-md-6 p-2">
                    <label for="barang" class="required">Barang</label>
                    <select class="custom-select" wire:model="barang" id="barang" required disabled>
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
                    <select class="custom-select" wire:model="ruangan" id="ruangan" required disabled>
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
                    <label for="date">Tanggal</label>
                    <input type="date" wire:model="date" id="date" class="form-control" placeholder="Kode Barang"
                        aria-describedby="date" disabled>
                </div>
                @if ($inventoryBarang->barang->category->name == "Alat Kebersihan")
                <div class="col-md-6 p-2" id="jumlah">
                    <label for="jumlah_barang">Jumlah Barang</label>
                    <input type="number" wire:model="jumlah_barang" id="jumlah_barang" class="form-control"
                        placeholder="Masukkan Jumlah Barang" aria-describedby="jumlah_barang">
                    <small id="jumlah_barang" class="form-text text-muted">
                        Penting: Jika ini barang alat kebersihan seperti sapu silahkan masukkan perkelas ada berapa
                        sapunya.
                    </small>
                </div>
                @endif
            </div>
            <div class="d-flex justify-content-between">
                <a wire:click='$set("page", "index")' class="btn btn-danger">Batal Update</a>
                <div class="d-flex align-item-center">
                    <div class="spinner-border text-primary mr-2" role="status" wire:loading>
                        <span class="sr-only">Loading...</span>
                    </div>
                    @if ($inventoryBarang->barang->category->name == "Alat Kebersihan")
                    <button type="submit" class="btn btn-primary">Update Inventory Barang</button>
                    @endif
                </div>
            </div>
        </form>
        @endif

        {{-- ================================ SHOW ==================================== --}}
        @if ($page == "show")
        <div class="text-end">
            <a wire:click='$set("page", "index")' class="btn btn-primary my-2 p-2">Back</a>
        </div>
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
                        <td>{{ $updated_at . '|' . $updated_at->diffForHumans() }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- ===================================== Kondisi Barang ======================================= --}}
        <div class="text-end py-2">
            <form action="{{route('kondisiBarang.create')}}" method="get">
                <input type="hidden" value="khGshjaghfhjFHJfjhdgxjhafghfR%45Us875d7gjhgJGFYfyGUtit8&)7r87tut*&56UT^$67R^&$6FGYr&^E6iOHO:kp[oJPyUIui&ruFyifR^&e67FYUFr67e^&fuyR&^rGIUR&r87FUIr87R&Yr^hyFTfuy8as5d78gFUYRydadta7587gT7tdas6duiasir67r^Dr6srdasfrd6r67iuT78sd7asdrYR6udaidgas87d" name="cd">
                <input type="hidden" value="{{$inv_brg_id}}" name="kv">
                <button type="submit" class="btn btn-primary">Create Kondisi Barang</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Kondisi</th>
                        <th scope="col">Status Barang</th>
                        <th scope="col">Detail Kondisi</th>
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
                            <a wire:click='showDetailKondisi({{$item->id}})' class="btn btn-primary">
                                Show Detail Barang
                            </a>
                        </td>
                        <td class="align-middle">
                            <a class="btn btn-info m-1" href="{{route('kondisiBarang.edit', $item->id)}}">Edit</a>
                            <a class="btn btn-danger m-1" data-toggle="modal"
                                data-target="#delete-kondisi-barang{{$item->id}}">Delete</a>
                        </td>
                    </tr>

                    <!-- Modal Create Kondisi Barang -->
                    <div class="modal fade" id="delete-kondisi-barang{{$item->id}}" tabindex="-1"
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

        @if ($page == 'showDetailKondisi')
        <div class="text-end">
        <a wire:click='show({{$inv_brg_id}})' class="btn btn-primary my-2 p-2">Kembali</a>
        </div>
        <div class="card">
            {!! $detail_kondisi !!}
        </div>
        @endif

        <!-- Modal Create Kondisi Barang -->
        <div class="modal fade" id="create-kondisi-barang" tabindex="-1" aria-labelledby="create-kondisi-barangLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
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
                                <div class="form-group">
                                    <label for="date">Tanggal</label>
                                    <input type="date" name="date" id="date" class="form-control">
                                </div>
                                <div class="form-group">
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
                                <div class="form-group">
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
                                <div class="form-group">
                                    <label for="images" class="required">Upload Images</label>
                                    <input type="file" name="images" id="images" class="form-control"
                                        accept=".png,.jpg,.jpeg,JPG,PNG,JPEG,.gif,.GIF">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan Barang</label>
                                    <textarea name="keterangan" id="keterangan" cols="30" rows="10"
                                        class="form-control"></textarea>
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
                        <h5 class="modal-title text-danger" id="edit-kondisi-barangLabel">Update Kondisi
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