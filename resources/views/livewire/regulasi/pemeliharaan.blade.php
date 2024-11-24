<div>
    @push('css')

    @endpush
    <div>

        {{-- ====================================== INDEX ===================================== --}}
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
                    <a class="btn btn-primary mx-2" href="{{route('pemeliharaan.create')}}">Create New
                        Pemeliharaan</a>
                    <a href="#/filter" class="text-decoration-none text-light">
                        <i class="fa-solid fa-filter"></i>
                    </a>
                </div>
            </div>
            <caption>List of Pemeliharaan Barang</caption>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Sarana</th>
                        <th scope="col">Kode Barang</th>
                        <th scope="col">Jenis Pemeliharaan</th>
                        <th scope="col">Tanggal Mulai</th>
                        <th scope="col">Tanggal Selesai</th>
                        <th scope="col">Biaya</th>
                        <th scope="col">Penanggung Jawab</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pms as $key => $pm)
                    <tr>
                        <th scope="row">{{ $pm->sarana->nama_sarana }}</th>
                        <td>{{ $pm->kode_barang ?? "-" }}</td>
                        <td>{{ $pm->jenis_pemeliharaan }}</td>
                        <td>{{ $pm->tanggal_mulai }}</td>
                        <td>{{ $pm->tanggal_selesai }}</td>
                        <td>{{ $pm->biaya }}</td>
                        <td>{{ $pm->penanggung_jawab }}</td>
                        <td>
                            <p class="badge 
                            {{ $pm->status == 'Validasi' ? 'badge-warning' : '' }}
                            {{ $pm->status == 'Disetujui' ? 'badge-success' : '' }}
                            {{ $pm->status == 'Verifikasi' ? 'badge-warning' : '' }}
                            {{ $pm->status == 'Verifikasi Sukses' ? 'badge-success' : '' }}
                            {{ $pm->status == 'Realisasi' ? 'badge-info' : '' }}
                            {{ $pm->status == 'Error' ? 'badge-danger' : '' }}
                            {{ $pm->status == 'Batal' ? 'badge-danger' : '' }}
                            {{ $pm->status == 'Pending' ? 'badge-warning' : '' }}
                            {{ $pm->status == 'Tidak Disetujui' ? 'badge-danger' : '' }}
                            {{ $pm->status == 'Dalam Pengerjaan' ? 'badge-info' : '' }}
                            {{ $pm->status == 'Selesai' ? 'badge-success' : '' }}
                            {{ empty($pm->status) ? 'badge-secondary' : '' }}">
                                {{ $pm->status }}
                            </p>
                        </td>
                        <td>
                            <a wire:click='show({{$pm->id}})' class="btn btn-info">Show</a>
                            <a href="{{ route('pemeliharaan.edit', $pm->kode_pemeliharaan) }}" class="btn btn-primary">Edit</a>
                            <a class="btn btn-danger" data-toggle="modal" data-target="#deletestaf{{$pm->id}}">Delete</a>
                        </td>
                    </tr>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="deletestaf{{$pm->id}}" tabindex="-1" aria-labelledby="deletestafLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="deletestafLabel">Yakin delete pemeliharaan
                                        dengan
                                        Kode : {{ $pm->kode_pemeliharaan }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer text-end">
                                    <form wire:submit.prevent='delete({{$pm->id}})'>
                                        <div class="d-flex align-item-center">
                                            <div class="spinner-border text-primary mr-2" role="status" wire:loading
                                                wire:target="delete">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <button type="submit" class="btn btn-danger" data-dismiss="modal">Delete {{
                                                $pm->kode_pemeliharaan
                                                }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr class="text-center">
                        <td colspan="10">Tidak ada data terbaru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="text-center">
                {{ $pms->links() }}
            </div>
        </div>
        @endif

        {{-- ============================= SHOW =============================== --}}
        @if ($page == 'show')
        <div class="bg-black p-2 my-2 rounded d-flex justify-content-between align-items-center">
            <h6>{{ $data_pemeliharaan->jenis_pemeliharaan }}</h6>
            <a wire:click='back' class="btn btn-primary">Back</a>
        </div>
        <hr class="text-black" style="color:black;">
        <div class="row p-2">
            <div class="col-md-6 text-center bg-secondary p-3">
                Kode Pemeliharaan
            </div>
            <div class="col-md-6 p-3">
                {{$data_pemeliharaan->kode_pemeliharaan}}
            </div>
        </div>
        <hr class="text-black" style="color:black;">
        <div class="row p-2">
            <div class="col-md-6 text-center bg-secondary p-3">
                Sumber Dana
            </div>
            <div class="col-md-6 p-3">
                {{$data_pemeliharaan->sumber_dana}}
            </div>
        </div>
        <hr class="text-black" style="color:black;">
        <div class="row p-2">
            <div class="col-md-6 text-center bg-secondary p-3 m-auto">
                Kondisi Sebelum
            </div>
            <div class="col-md-6 p-0">
                <img src="{{asset($data_pemeliharaan->kondisi_sebelum)}}" alt="" srcset=""
                    class="img-thumbnail img-fluid">
            </div>
        </div>
        <hr class="text-black" style="color:black;">
        <div class="row p-2">
            <div class="col-md-6 text-center bg-secondary p-3 m-auto">
                Kondisi Sesudah
            </div>
            <div class="col-md-6 p-0">
                <img src="{{asset($data_pemeliharaan->kondisi_sesudah)}}" alt="" srcset=""
                    class="img-thumbnail img-fluid">
            </div>
        </div>
        <hr class="text-black" style="color:black;">
        <table class="table">
            <tr>
                <th>
                <td>Dokumen Pendukung</td>
                <td><a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#dokumenPendukung">Show</a></td>
                </th>
            </tr>
            <tr>
                <th>
                <td>Status</td>
                <td><span class="badge p-2
                        {{ $data_pemeliharaan->status == 'Validasi' ? 'badge-warning' : '' }}
                        {{ $data_pemeliharaan->status == 'Disetujui' ? 'badge-success' : '' }}
                        {{ $data_pemeliharaan->status == 'Verifikasi' ? 'badge-warning' : '' }}
                        {{ $data_pemeliharaan->status == 'Verifikasi Sukses' ? 'badge-success' : '' }}
                        {{ $data_pemeliharaan->status == 'Realisasi' ? 'badge-info' : '' }}
                        {{ $data_pemeliharaan->status == 'Error' ? 'badge-danger' : '' }}
                        {{ $data_pemeliharaan->status == 'Batal' ? 'badge-danger' : '' }}
                        {{ $data_pemeliharaan->status == 'Pending' ? 'badge-warning' : '' }}
                        {{ $data_pemeliharaan->status == 'Tidak Disetujui' ? 'badge-danger' : '' }}
                        {{ $data_pemeliharaan->status == 'Dalam Pengerjaan' ? 'badge-info' : '' }}
                        {{ $data_pemeliharaan->status == 'Selesai' ? 'badge-success' : '' }}
                        {{ empty($data_pemeliharaan->status) ? 'badge-secondary' : '' }}">
                        {{ $data_pemeliharaan->status }}
                    </span>
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatus">Update</a>
                </td>
                </th>
            </tr>
        </table>

        {{-- ==================== Modal Show Dokumen Pendukung ================= --}}
        <div class="modal fade" id="dokumenPendukung" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="dokumenPendukungLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dokumenPendukungLabel">Dokumen Pendukung Lainnya</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {!!$data_pemeliharaan->dokumen_pendukung!!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- ================================= End ============================= --}}

        {{-- ==================== Modal Update Status ================= --}}
        <div class="modal fade" id="updateStatus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="updateStatusLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusLabel">Update Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card text-start">
                                    <div class="card-header text-center bg-primary">
                                        Status yang tersedia
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            @foreach ($status as $item)
                                            <li>{{ $item['name'] }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card text-start">
                                    <div class="card-header text-center bg-info">
                                        Ketentuan
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled">
                                            @foreach($status as $item)
                                            <li>Status {{ $item['name'] }} :
                                                <ul>
                                                    <li>{{ $item['keterangan'] }}</li>
                                                </ul>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <form wire:submit.prevent='updateStatus({{$data_pemeliharaan->id}})'>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="status">Perbaharui Status</label>
                                    <select wire:model="status_update" id="status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <optgroup label="Status Pemeliharaan">
                                            @foreach ($status as $item)
                                                <option value="{{$item['name']}}">{{$item['name']}}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" wire:model="keterangan" id="" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" class="d-none" id="submitStatusPemeliharaan">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="document.getElementById('submitStatusPemeliharaan').click()">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- ================================= End ============================= --}}
        @endif

        {{-- =========================== UPDATE =========================== --}}
        @if ($page == "update")
        <div class="text-end">
            <a wire:click='show({{ $idstaf }})' class="btn btn-primary mx-2">Show</a>
            <a wire:click='back' class="btn btn-primary">Back</a>
        </div>
        <form wire:submit.prevent='edit'>
            <div class="row">
                <div class="col-md-6">
                    <div class="text-center border-bottom border-primary">
                        <p>Create Pemeliharaan</p>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error(" email") is-invalid @enderror" id="email"
                            placeholder="name@example.com" value="{{ old('email') }}" wire:model="email" required>
                        <label for="email" class="required">Email address</label>
                        @error('email')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Username" id="username"
                            wire:model="username" value="{{ old('username') }}" required
                            oninput="this.value = this.value.replace(/\s/g, '')">
                        <label for="username" class="required">Username</label>
                        @error('username')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center border-bottom border-primary">
                        <p>Personal</p>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" placeholder="I Made Sena Pernata"
                            value="{{ old('name') }}" wire:model="name" id="name" required>
                        <label for="name" class="required">Nama Lengkap</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="jenis_staf" placeholder="Jabatan"
                            value="{{ old('jenis_staf') }}" wire:model="jenis_staf" id="jenis_staf" required>
                        <label for="jenis_staf" class="required">Profesi / Jabatan / Jenis Staf / Bidang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="instansi" placeholder="Jabatan"
                            wire:model="instansi" id="instansi" required>
                        <label for="instansi" class="required">Asal Sekolah / Instansi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" wire:model="nip" id="nohp" placeholder="Masukksan No HP"
                            value="{{ old('nip') }}" min="0" step="1"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <label for="nohp">nip</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="alamat" placeholder="Alamat"
                            value="{{ old('alamat') }}" wire:model="alamat" id="alamat">
                        <label for="alamat">Alamat</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" wire:model="no_hp" id="nohp"
                            placeholder="Masukksan No HP" value="{{ old('no_hp') }}" min="0" step="1"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <label for="nohp">No Hp</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select wire:model="gender" id="gender" class="form-control">
                            <option>Pilih jenis Kelamin</option>
                            <optgroup label="Pilih Jenis Kelamin">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </optgroup>
                        </select>
                        <label for="gender">Gender / Jenis Kelamin</label>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary">Reset Form</button>
                    <div class="d-flex align-item-center">
                        <div class="spinner-border text-primary mr-2" role="status" wire:loading wire:target="edit">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Staf</button>
                    </div>
                </div>
            </div>
        </form>
        @endif
    </div>
</div>