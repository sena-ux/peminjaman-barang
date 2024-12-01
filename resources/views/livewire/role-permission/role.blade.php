<div>
    {{-- ============================== Index ================================= --}}
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
                @can('create role')
                <a wire:click='$set("page", "create")' class="btn btn-primary mx-2">Create new Role</a>
                @endcan
            </div>
        </div>
        {{-- <caption>List of users staf</caption> --}}
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Guard Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $key => $role)
                <tr>
                    <th scope="row">{{ $roles->firstItem() + $key }}</th>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->guard_name }}</td>
                    <td>
                        @can('show role')
                        <a wire:click='show({{$role->id}})' class="btn btn-info">Show</a>
                        @endcan
                        @can('edit role')
                        <a wire:click='edit({{$role->id}})' class="btn btn-primary">Edit</a>
                        @endcan
                        @can('delete role')
                        <a class="btn btn-danger" data-toggle="modal" data-target="#deleterole{{$role->id}}">Delete</a>
                        @endcan
                        @role('superadmin')
                        <a href="{{route('asignToRole.edit', $role->id)}}" class="btn btn-warning">Show Permissions</a>
                        @endrole
                    </td>
                </tr>
                
                <!-- Modal Delete -->
                <div class="modal fade" id="deleterole{{$role->id}}" tabindex="-1" aria-labelledby="deleteroleLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger" id="deleteroleLabel">Yakin delete role dengan
                                    Name : {{ $role->name }}</h5>
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
                                        wire:click.prevent='delete({{$role->id}})' data-dismiss="modal">Delete {{ $role->name
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
            {{ $roles->links() }}
        </div>
    </div>
    @endif

    {{-- ======================================= Create ================================== --}}
    @if ($page == 'create')
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h6 class="text-bold mt-auto pt-auto">Create New Role</h6>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='store'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" name") is-invalid @enderror" id="nama_role"
                placeholder="Contoh : Lab Bahasa" value="{{ old('nama_role') }}" wire:model="name" required>
            <label for="nama_role" class="required">Nama Role</label>
            @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="guard_name" id="guard_name" wire:model="guard_name"
                value="{{ old('guard_name') }}" required>
            <label for="guard_name">Guard Name</label>
            @error('guard_name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="d-flex justify-content-between">
            <button type="reset" class="btn btn-secondary">Reset Form</button>
            <div class="d-flex align-item-center">
                <div class="spinner-border text-primary mr-2" role="status" wire:loading wire:target="store">
                    <span class="sr-only">Loading...</span>
                </div>
                <button type="submit" class="btn btn-primary">Create & Other role</button>
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
                    <th scope="col">Name</th>
                    <th scope="col">Guard Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $name }}</td>
                    <td>{{ $guard_name }}</td>
                    <td>
                        <a wire:click='$set("page", "edit")' class="btn btn-primary">Update</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    {{-- =============================== Edit =========================================== --}}
    @if ($page == "edit")
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h6 class="text-bold mt-auto pt-auto">Update Role</h6>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='update({{ $role_id }})'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" name") is-invalid @enderror" id="nama_role"
                placeholder="Contoh : Lab Bahasa" value="{{ old('name') }}" wire:model="name" required>
            <label for="nama_role" class="required">Name</label>
            @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="guard_name" id="guard_name" wire:model="guard_name"
                value="{{ old('guard_name') }}" required>
            <label for="guard_name">Guard Name</label>
            @error('guard_name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <button type="reset" class="btn btn-secondary">Reset Form</button>
            <div class="d-flex align-item-center">
                <div class="spinner-border text-primary mr-2" role="status" wire:loading wire:target="update">
                    <span class="sr-only">Loading...</span>
                </div>
                <button type="submit" class="btn btn-primary">Update role</button>
            </div>
        </div>
    </form>
    @endif
</div>