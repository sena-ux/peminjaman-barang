<div>
    {{-- ============================== Index ================================= --}}
    @if ($page == 'index')
    <div class="row">
        <div class="d-flex justify-content-between pb-3">
            {{-- <div>
                <div>
                    @if ($permissions->count() >= 10)
                    <label for="">Page : </label>
                    <select wire:model.live="paginate" id="">
                        <option value="10">10</option>
                        @if ($permissions->count() >= 20)
                        <option value="20">20</option>
                        @endif
                    </select>
                    @endif
                </div>
            </div> --}}
            <div class="ml-auto">
                <a wire:click='$set("page", "create")' class="btn btn-primary mx-2">Create new permission</a>
            </div>
        </div>
        <caption>List of user permissions.</caption>
        <table class="table table-dark dataTableResponsive">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Group</th>
                    <th scope="col">Guard Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $key => $permission)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->group }}</td>
                    <td>{{ $permission->guard_name }}</td>
                    <td>
                        <a wire:click='show({{$permission->id}})' class="btn btn-info">Show</a>
                        <a wire:click='edit({{$permission->id}})' class="btn btn-primary">Edit</a>
                        <a class="btn btn-danger" data-toggle="modal"
                            data-target="#deletepermission{{$permission->id}}">Delete {{ $permission->name }}</a>
                    </td>
                </tr>

                <!-- Modal Delete -->
                <div class="modal fade" id="deletepermission{{$permission->id}}" tabindex="-1"
                    aria-labelledby="deletepermissionLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger" id="deletepermissionLabel">Yakin delete permission
                                    dengan
                                    Name : {{ $permission->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer text-end">
                                <div class="d-flex align-item-center">
                                    <div class="spinner-border text-primary mr-2" permission="status" wire:loading
                                        wire:target="delete">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <button type="submit" class="btn btn-danger"
                                        wire:click.prevent='delete({{$permission->id}})' data-dismiss="modal">Delete {{
                                        $permission->name
                                        }}</button>
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

    {{-- ======================================= Create ================================== --}}
    @if ($page == 'create')
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h6 class="text-bold mt-auto pt-auto">Create New permission</h6>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='store'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" name") is-invalid @enderror" id="nama_permission"
                placeholder="Contoh : Lab Bahasa" value="{{ old('nama_permission') }}" wire:model="name" required>
            <label for="nama_permission" class="required">Nama permission</label>
            @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" name") is-invalid @enderror" id="nama_permission"
                placeholder="Grouping name" value="{{ old('nama_permission') }}" wire:model="group" required>
            <label for="nama_permission" class="required">Group</label>
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
                <div class="spinner-border text-primary mr-2" permission="status" wire:loading wire:target="store">
                    <span class="sr-only">Loading...</span>
                </div>
                <button type="submit" class="btn btn-primary">Create & Other permission</button>
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
                    <th scope="col">Group</th>
                    <th scope="col">Guard Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $name }}</td>
                    <td>{{ $group }}</td>
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
        <h6 class="text-bold mt-auto pt-auto">Update permission</h6>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='update({{ $permission_id }})'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" name") is-invalid @enderror" id="nama_permission"
                placeholder="Contoh : Lab Bahasa" value="{{ old('name') }}" wire:model="name" required>
            <label for="nama_permission" class="required">Name</label>
            @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" name") is-invalid @enderror" id="nama_permission"
                placeholder="Grouping name" value="{{ old('nama_permission') }}" wire:model="group" required>
            <label for="nama_permission" class="required">Group</label>
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
                <div class="spinner-border text-primary mr-2" permission="status" wire:loading wire:target="update">
                    <span class="sr-only">Loading...</span>
                </div>
                <button type="submit" class="btn btn-primary">Update permission</button>
            </div>
        </div>
    </form>
    @endif
</div>