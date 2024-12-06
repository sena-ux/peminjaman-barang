<div>
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
                <a wire:click='create' class="btn btn-primary mx-2">Create Staf</a>
                <a href="#/filter" class="text-decoration-none text-light">
                    <i class="fa-solid fa-filter"></i>
                </a>
            </div>
        </div>
        {{-- <caption>List of users staf</caption> --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Username</th>
                    <th scope="col">Profesi</th>
                    <th scope="col">Instansi</th>
                    <th scope="col">NIP</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stafs as $key => $staf)
                <tr>
                    <th scope="row">{{ $stafs->firstItem() + $key }}</th>
                    <td>{{ $staf->name }}</td>
                    <td>{{ $staf->user->email }}</td>
                    <td>{{ $staf->user->username }}</td>
                    <td>{{ $staf->jenis_staff ?? "-" }}</td>
                    <td>{{ $staf->instansi ?? "-" }}</td>
                    <td>{{ $staf->NIP ?? "-" }}</td>
                    <td>
                        <a wire:click='show({{$staf->id}})' class="btn btn-info">Show</a>
                        <a wire:click='update({{$staf->id}})' class="btn btn-primary">Edit</a>
                        <a class="btn btn-danger" data-toggle="modal" data-target="#deletestaf">Delete</a>
                    </td>
                </tr>

                <!-- Modal Delete -->
                <div class="modal fade" id="deletestaf" tabindex="-1" aria-labelledby="deletestafLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger" id="deletestafLabel">Yakin delete staf dengan
                                    username : {{ $staf->user->username }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer text-end">
                                <form wire:submit.prevent='delete({{$staf->user->id}})'>
                                    <div class="d-flex align-item-center">
                                        <div class="spinner-border text-primary mr-2" role="status" wire:loading
                                            wire:target="delete">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <button type="submit" class="btn btn-danger">Delete {{ $staf->user->username
                                            }}</button>
                                    </div>
                                </form>
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
            {{ $stafs->links() }}
        </div>
    </div>
    @endif
    @if ($page == 'create')
    <div class="text-end">
        <a wire:click='back' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='store'>
        <div class="row">
            <div class="col-md-6">
                <div class="text-center border-bottom border-primary">
                    <p>Authentication</p>
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
                    <input type="text" class="form-control" placeholder="Username" id="username" wire:model="username"
                        value="{{ old('username') }}" required oninput="this.value = this.value.replace(/\s/g, '')">
                    <label for="username" class="required">Username</label>
                    @error('username')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password" id="password" wire:model="password" required>
                    <label for="password" class="required">Password</label>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Password" id="confirmpassword" wire:model="password_confirmation"
                        value="{{ old('password_confirmation') }}" required>
                    <label for="confirmpassword" class="required">Confirmation Password</label>
                    @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
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
                        <select name="wali_kelas" id="wali_kelas" wire:model="wali_kelas" class="form-control">
                            <option value="">Select Kelas</option>
                            @forelse (\App\Models\Kelas::all() as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                                <option value="" disabled>Data Kelas Kosong</option>
                            @endforelse
                        </select>
                    <label for="wali_kelas">Wali Kelas</label>
                    <small>Hanya di isi jika status sebagai Wali Kelas.</small>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="instansi" placeholder="Jabatan" wire:model="instansi"
                        id="instansi" required>
                    <label for="instansi" class="required">Asal Sekolah / Instansi</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" wire:model="nip" id="nohp" placeholder="Masukksan No HP"
                        value="{{ old('nip') }}" min="0" step="1"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    <label for="nohp">nip</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="alamat" placeholder="Alamat" value="{{ old('alamat') }}"
                        wire:model="alamat" id="alamat">
                    <label for="alamat">Alamat</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" wire:model="no_hp" id="nohp" placeholder="Masukksan No HP"
                        value="{{ old('no_hp') }}" min="0" step="1"
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
                    <div class="spinner-border text-primary mr-2" role="status" wire:loading wire:target="store">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Staf</button>
                </div>
            </div>
        </div>
    </form>
    @endif
    @if ($page == 'show')
    <div class="text-end">
        <a wire:click='update({{ $idstaf }})' class="btn btn-primary mx-2">Update</a>
        <a wire:click='back' class="btn btn-primary">Back</a>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="text-center border-bottom border-primary">
                <p>Authentication</p>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error(" email") is-invalid @enderror" id="email"
                    placeholder="name@example.com" value="{{ old('email') }}" wire:model="email" required disabled>
                <label for="email" class="required">Email address</label>
                @error('email')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" placeholder="Username" id="username" wire:model="username"
                    value="{{ old('username') }}" required oninput="this.value = this.value.replace(/\s/g, '')"
                    disabled>
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
                    value="{{ old('name') }}" wire:model="name" id="name" required disabled>
                <label for="name" class="required">Nama Lengkap</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="jenis_staf" placeholder="Jabatan"
                    value="{{ old('jenis_staf') }}" wire:model="jenis_staf" id="jenis_staf" required disabled>
                <label for="jenis_staf" class="required">Profesi / Jabatan / Jenis Staf / Bidang</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="instansi" placeholder="Jabatan" wire:model="instansi"
                    id="instansi" required disabled>
                <label for="instansi" class="required">Asal Sekolah / Instansi</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" wire:model="nip" id="nohp" placeholder="Masukksan No HP"
                    value="{{ old('nip') }}" min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    disabled>
                <label for="nohp">nip</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="alamat" placeholder="Alamat" value="{{ old('alamat') }}"
                    wire:model="alamat" id="alamat" disabled>
                <label for="alamat">Alamat</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" wire:model="no_hp" id="nohp" placeholder="Masukksan No HP"
                    value="{{ old('no_hp') }}" min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    disabled>
                <label for="nohp">No Hp</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" wire:model="gender" disabled id="" class="form-control">
                <label for="gender">Gender / Jenis Kelamin</label>
            </div>
        </div>
    </div>
    @endif
    @if ($page == "update")
    <div class="text-end">
        <a wire:click='show({{ $idstaf }})' class="btn btn-primary mx-2">Show</a>
        <a wire:click='back' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='edit'>
        <div class="row">
            <div class="col-md-6">
                <div class="text-center border-bottom border-primary">
                    <p>Authentication</p>
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
                    <input type="text" class="form-control" placeholder="Username" id="username" wire:model="username"
                        value="{{ old('username') }}" required oninput="this.value = this.value.replace(/\s/g, '')">
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
                    <input type="text" class="form-control" id="instansi" placeholder="Jabatan" wire:model="instansi"
                        id="instansi" required>
                    <label for="instansi" class="required">Asal Sekolah / Instansi</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" wire:model="nip" id="nohp" placeholder="Masukksan No HP"
                        value="{{ old('nip') }}" min="0" step="1"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    <label for="nohp">nip</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="alamat" placeholder="Alamat" value="{{ old('alamat') }}"
                        wire:model="alamat" id="alamat">
                    <label for="alamat">Alamat</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" wire:model="no_hp" id="nohp" placeholder="Masukksan No HP"
                        value="{{ old('no_hp') }}" min="0" step="1"
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