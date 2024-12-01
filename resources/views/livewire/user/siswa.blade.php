@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">User Manajement</li>
<li class="breadcrumb-item active">Siswa</li>
@section('action')
<a wire:click='$set("page", "index")' class="btn btn-outline-primary">Index</a>
@endsection
@endsection
<div>
    <div class="row">
        {{-- ============================ Index ====================================== --}}
        @if ($page == 'index')
        <div class="d-flex bg-secondary p-2 my-2 rounded">
            <a wire:click='$set("page", "import")' class="btn btn-info mx-2">Import Siswa</a>
            <div class="ml-auto">
                <a wire:click='create' class="btn btn-primary mx-2">Create Siswa</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered dataTableResponsive">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">NISN</th>
                        <th scope="col">No Hp</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswas as $key => $siswa)
                    <tr>
                        <th class="align-middle" scope="row">{{ $key + 1 }}</th>
                        <td class="align-middle">{{ $siswa->user->username }}</td>
                        <td class="align-middle">{{ $siswa->user->email }}</td>
                        <td class="align-middle">{{ $siswa->name }}</td>
                        <td class="align-middle">{{ $siswa->nisn }}</td>
                        <td class="align-middle">{{ $siswa->no_hp }}</td>
                        <td class="align-middle">{{ $siswa->kelas->name }}</td>
                        <td class="align-middle">
                            {{-- @can('show siswa') --}}
                            <a wire:click='show({{$siswa->id}})' class="btn btn-info">Show</a>
                            {{-- @elsecan('edit siswa') --}}
                            <a wire:click='edit({{$siswa->id}})' class="btn btn-primary">Update</a>
                            {{-- @elsecan('delete siswa') --}}
                            <a class="btn btn-danger m-1" data-toggle="modal"
                            data-target="#deletesiswa{{$siswa->id}}">Delete</a>
                            {{-- @endcan --}}
                            @role('superadmin')
                            <a href="{{route('asignToUser.edit', $siswa->user_id)}}" class="btn btn-warning">Show Permissions</a>
                            @endrole
                        </td>
                    </tr>

                    {{-- Delete siswa --}}
                    <div class="modal fade" id="deletesiswa{{$siswa->id}}" tabindex="-1"
                        aria-labelledby="deletesiswaLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="deletesiswaLabel">Delete siswa
                                        {{$siswa->user->username}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger"
                                        wire:click='delete({{$siswa->user->id}})' data-dismiss="modal">Delete
                                        {{$siswa->user->username}}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Show Image -->
                    <div class="modal fade" id="showImage{{$siswa->id}}" data-backdrop="static" data-keyboard="false"
                        tabindex="-1" aria-labelledby="showImage{{$siswa->id}}Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showImage{{$siswa->id}}Label">Show Image</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{asset($siswa->foto_siswa)}}" alt="Foto siswa"
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
            <a wire:click='$set("page", "import")' class="btn btn-info mx-2">Import Siswa</a>
            <div class="ml-auto">
                <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
            </div>
        </div>
        <form wire:submit.prevent='store'>
            <div class="form-row">
                <div class="col-md-6 p-2">
                    <label for="namasiswa" class="required">Nama siswa</label>
                    <input type="text" wire:model="name" id="namasiswa" class="form-control"
                        placeholder="Masukkan nama siswa..." required>
                </div>
                <div class="col-md-6 p-2">
                    <label for="nisn" class="required">NISN</label>
                    <input type="text" wire:model="nisn" id="nisn" class="form-control"
                        placeholder="Masukkan NISN yang sesuai..." maxlength="10"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required>
                </div>
                <div class="col-md-6 p-2">
                    <label for="nis" class="required">NIS</label>
                    <input type="text" wire:model="nis" id="nis" class="form-control"
                        placeholder="Masukkan nis yang sesuai" maxlength="15"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)" required>
                </div>
                <div class="col-md-6 p-2">
                    <label for="no_hp">No Hp</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">+62</span>
                        </div>
                        <input type="text" id="no_hp" class="form-control" maxlength="12"
                            placeholder="Masukkan no hp..." wire:model='no_hp'
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);">
                    </div>
                </div>
                <div class="col-md-6 p-2">
                    <label for="kelas" class="required">Kelas</label>
                    <select wire:model="kelas_id" id="kelas" class="form-control" required>
                        <option value="">Select Kelas</option>
                        <optgroup label="Kelas">
                            @forelse ($kelas as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            <option value="" disabled>Data not pound!</option>
                            @endforelse
                        </optgroup>
                    </select>
                </div>
                <hr>
                <div class="col-md-6 p-2">
                    <label for="username" class="required">Username</label>
                    <input type="text" wire:model="username" id="username" class="form-control"
                        placeholder="Masukkan username tanpa spasi..."
                        oninput="this.value = this.value.replace(/\s/g, '')" required>
                </div>
                <div class="col-md-6 p-2">
                    <label for="email" class="required">Email</label>
                    <input type="email" wire:model="email" id="email" class="form-control"
                        placeholder="Masukkan email yang sesuai..." required>
                </div>
                <div class="col-md-6 p-2">
                    <label for="alamat">Alamat</label>
                    <input type="text" wire:model="alamat" id="alamat" class="form-control"
                        placeholder="Masukkan alamat anda ...">
                </div>
                <div class="col-md-6 p-2 password">
                    <label for="password" class="form-label required">Password</label>
                    <div class="icon">
                        <input type="password" class="form-control" id="password" wire:model="password"
                            placeholder="Enter your password" oninput="this.value = this.value.replace(/\s/g, '')"
                            required>
                        <i class="fa-solid fa-eye"
                            onclick="passwordShow(document.getElementById('password'), this)"></i>
                    </div>
                    @error('password')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 8.
                    </div>
                </div>
                <div class="col-md-6 p-2 password">
                    <label for="password_confirmation" class="required">Confirm Password</label>
                    <div class="icon">
                        <input type="password" wire:model="password_confirmation" id="password_confirmation"
                            class="form-control" required>
                        <i class="fa-solid fa-eye"
                            onclick="passwordShow(document.getElementById('password_confirmation'), this)"></i>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Create New Siswa</button>
            </div>
        </form>
        @endif

        {{-- ================================ SHOW ==================================== --}}
        @if ($page == "show")
        <div class="d-flex bg-secondary p-2 my-2 rounded">
            <div class="ml-auto">
                <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
                <a wire:click='edit({{$siswa->id}})' class="btn btn-info">Update</a>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 text-center p-3">
                <img src="{{asset($siswa->foto)}}" alt="Foto Profile" class="img-fluid img-thumbnail" width="320">
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"><span>Username </span></div>
                            <div class="col-md-6"><span> : {{$siswa->user->username}}</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"><span>Email </span></div>
                            <div class="col-md-6"><span> : {{$siswa->user->email}}</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"><span>Nama Lengkap </span></div>
                            <div class="col-md-6"><span> : {{$siswa->name}}</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"><span>NISN </span></div>
                            <div class="col-md-6"><span> : {{$siswa->nisn}}</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"><span>NIS </span></div>
                            <div class="col-md-6"><span> : {{$siswa->nis}}</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"><span>Kelas </span></div>
                            <div class="col-md-6"><span> : {{$siswa->kelas->name}}</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"><span>No HP </span></div>
                            <div class="col-md-6"><span> : {{$siswa->no_hp ?? "-"}}</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"><span>Alamat</span></div>
                            <div class="col-md-6"><span> : {{$siswa->alamat ?? "-"}}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- =================================== Edit ==================================== --}}
        @if ($page == "edit")
        {{-- <div class="text-end">
            <a wire:click='$set("page", "index")' class="btn btn-primary my-2 p-2">Back</a>
        </div> --}}
        <form wire:submit.prevent='update({{$siswa->id}})'>
            <div class="form-row">
                <div class="col-md-6 p-2">
                    <label for="namasiswa" class="required">Nama siswa</label>
                    <input type="text" wire:model="name" id="namasiswa" class="form-control"
                        placeholder="Masukkan nama siswa..." required>
                </div>
                <div class="col-md-6 p-2">
                    <label for="nisn" class="required">NISN</label>
                    <input type="text" wire:model="nisn" id="nisn" class="form-control"
                        placeholder="Masukkan NISN yang sesuai..." maxlength="10"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required>
                </div>
                <div class="col-md-6 p-2">
                    <label for="nis" class="required">NIS</label>
                    <input type="text" wire:model="nis" id="nis" class="form-control"
                        placeholder="Masukkan nis yang sesuai" maxlength="15"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)" required>
                </div>
                <div class="col-md-6 p-2">
                    <label for="no_hp">No Hp</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">+62</span>
                        </div>
                        <input type="text" id="no_hp" class="form-control" maxlength="12"
                            placeholder="Masukkan no hp..." wire:model='no_hp'
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);">
                    </div>
                </div>
                <div class="col-md-6 p-2">
                    <label for="kelas" class="required">Kelas</label>
                    <select wire:model="kelas_id" id="kelas" class="form-control" required>
                        <option value="">Select Kelas</option>
                        <optgroup label="Kelas">
                            @forelse ($kelas as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            <option value="" disabled>Data not pound!</option>
                            @endforelse
                        </optgroup>
                    </select>
                </div>
                <hr>
                <div class="col-md-6 p-2">
                    <label for="username" class="required">Username</label>
                    <input type="text" wire:model="username" id="username" class="form-control"
                        placeholder="Masukkan username tanpa spasi..."
                        oninput="this.value = this.value.replace(/\s/g, '')" required>
                </div>
                <div class="col-md-6 p-2">
                    <label for="email" class="required">Email</label>
                    <input type="email" wire:model="email" id="email" class="form-control"
                        placeholder="Masukkan email yang sesuai..." required>
                </div>
                <div class="col-md-6 p-2">
                    <label for="alamat">Alamat</label>
                    <input type="text" wire:model="alamat" id="alamat" class="form-control"
                        placeholder="Masukkan alamat anda ...">
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Updated Siswa</button>
            </div>
        </form>
        @endif

        {{-- ============================= Import Siswa ================================= --}}
        @if ($page == "import")
        <div class="bg-secondary p-2 my-2 d-flex justify-content-between align-items-center rounded">
            <h6 class="text-bold mt-auto pt-auto">Import Siswa</h6>
            <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card text-start">
                    <div class="card-header">
                        <h5 class="card-title">Untuk import data Siswa silahkan download template import nya <a
                                class="btn btn-primary" wire:click.prevent='downloadTemplate'>Template Import</a>
                            <div class="spinner-border" role="status" wire:loading wire:loading.attr="disabled">
                                <span class="sr-only">Loading...</span>
                              </div>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('siswa.import')}}" enctype="multipart/form-data">
                            @method("POST")
                            @csrf
                            <input type="file" name="file" id="importSiswa" class="form-control" accept=".xlsx,.xls">
                            <button type="submit" class="btn btn-primary p-2 my-2">Import Siswa</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-start">
                    <div class="card-header">
                        Ketentuan Import Siswa
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Header tolong jangan di hapus yang berapa di baris pertama paling atas</li>
                            <li>Isi mulai dari baris kedua</li>
                            <li>Penulisan kelas menggunakan bilangan romawi, misalnya: <b>X.1, XI.1, XII.1, dan seterusnya...</b></li>
                            <li>Kolom tidak boleh kosong : <span class="text-danger">username, email, password, nisn, nis, kelas.</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>