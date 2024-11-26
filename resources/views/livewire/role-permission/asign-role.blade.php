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
                <input type="search" wire:model.live="search" id="" class="form-control">
            </div>
        </div>
        <caption>List of user users.</caption>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $key => $user)
                <tr>
                    <th class="align-middle" scope="row">{{ $users->firstItem() + $key }}</th>
                    <td class="align-middle">{{ $user->username }}</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <td class="align-middle">
                        <ul>
                            @foreach ($user->getRoleNames() as $key => $item)
                            <li>{{ $user->getRoleNames()[$key] }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="align-middle">
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#asignRole{{$user->id}}"
                            id="asignUser_id">Asign Role</a>
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteRole{{$user->id}}"
                            id="asignUser_id">Delete Role</a>
                    </td>
                    {{-- =============================== Asign Role =============================== --}}
                    <div class="modal fade" id="deleteRole{{$user->id}}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteRoleLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteRoleLabel">Asign Role dengan ID USER :
                                        {{$user->id}}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form wire:submit.prevent='deleteRole({{$user->id}})'>
                                        <label for="user">Select User</label>
                                        <select wire:model="role_name" id="user" class="form-control">
                                            <option value="">Select User</option>
                                            <optgroup label="User">
                                                @foreach ($listRole as $item)
                                                <option value="{{$item->name}}">{{ $item->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <button type="submit" id="asignRole" class="d-none">Submit</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="document.getElementById('asignRole').click()"
                                        data-bs-dismiss="modal">Asign Role {{ $role_name
                                        }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ===================================== End ================================= --}}
                    {{-- =============================== Asign Role =============================== --}}
                    <div class="modal fade" id="asignRole{{$user->id}}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="asignRoleLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="asignRoleLabel">Asign Role dengan ID USER :
                                        {{$user->id}}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form wire:submit.prevent='asign({{$user->id}})'>
                                        <label for="user">Select User</label>
                                        <select wire:model="role_name" id="user" class="form-control">
                                            <option value="">Select User</option>
                                            <optgroup label="User">
                                                @foreach ($listRole as $item)
                                                <option value="{{$item->name}}">{{ $item->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <button type="submit" id="asignRole" class="d-none">Submit</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="document.getElementById('asignRole').click()"
                                        data-bs-dismiss="modal">Asign Role {{ $role_name
                                        }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ===================================== End ================================= --}}
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="8">Tidak ada data terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="text-center">
            {{ $users->links() }}
        </div>
    </div>
    @endif

    {{-- ======================================= Create ================================== --}}
    @if ($page == 'create')
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h6 class="text-bold mt-auto pt-auto">Create New user</h6>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='store'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" name") is-invalid @enderror" id="nama_user"
                placeholder="Contoh : Lab Bahasa" value="{{ old('nama_user') }}" wire:model="name" required>
            <label for="nama_user" class="required">Nama user</label>
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
                <div class="spinner-border text-primary mr-2" user="status" wire:loading wire:target="store">
                    <span class="sr-only">Loading...</span>
                </div>
                <button type="submit" class="btn btn-primary">Create & Other user</button>
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
        <h6 class="text-bold mt-auto pt-auto">Update user</h6>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='update({{ $user_id }})'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" name") is-invalid @enderror" id="nama_user"
                placeholder="Contoh : Lab Bahasa" value="{{ old('name') }}" wire:model="name" required>
            <label for="nama_user" class="required">Name</label>
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
                <div class="spinner-border text-primary mr-2" user="status" wire:loading wire:target="update">
                    <span class="sr-only">Loading...</span>
                </div>
                <button type="submit" class="btn btn-primary">Update user</button>
            </div>
        </div>
    </form>
    @endif
</div>