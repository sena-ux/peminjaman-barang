<div>
    @section('linkLatest')
    <div wire:loading>
        Saving post...
    </div>
    @endsection
    {{-- ============================== Create ================================= --}}
    @if ($page == 'index')
    <div class="row">
        @canany(['create category'])
        <div class="bg-secondary d-flex justify-content-between p-2 my-2 rounded">
            <div class="right ml-auto">
                @can('create category')
                <a wire:click='$set("page", "create")' class="btn btn-primary">Create new Category</a>
                @endcan
            </div>
        </div>
        @endcanany
        {{-- <caption>List of users staf</caption> --}}
        <table class="table table-dark dataTableResponsive">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Category</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorys as $key => $category)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->deskripsi }}</td>
                    <td>
                        @can('show category')
                        <a wire:click='show({{$category->id}})' class="btn btn-info">Show</a>
                        @endcan
                        @can('update category')
                        <a wire:click='edit({{$category->id}})' class="btn btn-primary">Edit</a>
                        @endcan
                        @can('delete category')
                        <a class="btn btn-danger" data-toggle="modal"
                            data-target="#deleteCategory{{$category->id}}">Delete</a>
                        @endcan
                    </td>
                </tr>

                <!-- Modal Delete -->
                <div class="modal fade" id="deleteCategory{{$category->id}}" tabindex="-1"
                    aria-labelledby="deleteCategoryLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger" id="deleteCategoryLabel">Yakin delete category
                                    dengan
                                    Name : {{ $category->name }}</h5>
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
                                    <button type="submit" class="btn btn-danger" data-dismiss="modal"
                                        wire:click='delete({{$category->id}})'>Delete {{ $category->name
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
        <h3 class="text-bold mt-auto pt-auto">Create New Category</h3>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card text-start">
                <div class="card-header bg-info text-center">
                    Ketentuan membuat Nama Category
                </div>
                <div class="card-body">
                    <h5 class="card-title">Contoh pembuatan Nama Category : </h5>
                    <br>
                    <ul>
                        <li>Elektronika</li>
                        <li>Kelas</li>
                        <li>Alat Kebersihan</li>
                        <li>Umum</li>
                        <li>Dan yang lainnya</li>
                    </ul>
                </div>
                <div class="card-footer text-muted">
                    Untuk pemberian category mohon di perhatikan dan mengikuti ketentuan.
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <form wire:submit.prevent='store'>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error(" name") is-invalid @enderror" id="name"
                        placeholder="Contoh : Elektronika" value="{{ old('name') }}" wire:model="name" required>
                    <label for="name" class="required">Nama Category</label>
                    @error('name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
        
                <div class="form-floating mb-3">
                    <textarea class="form-control" wire:model="deskripsi" id="deskription" style="height: 100px"></textarea>
                    <label for="deskription">Deskripsi</label>
                    @error('deskripsi')
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
                        <button type="submit" class="btn btn-primary">Create & Other Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- ================================= Show =================================== --}}
    @if ($page == 'show')
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h5 class="text-bold mt-auto pt-auto">Show Category</h5>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <div class="table-responsive">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">Nama Category</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $name }}</td>
                    <td>{{ $deskripsi }}</td>
                    <td>
                        <a wire:click='$set("page", "edit")' class="btn btn-primary">Update</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    {{-- =============================== Update ============================== --}}
    @if ($page == "edit")
    <div class="bg-black p-3 my-2 d-flex justify-content-between align-items-center rounded">
        <h3 class="text-bold mt-auto pt-auto">Update Category</h3>
        <a wire:click='$set("page", "index")' class="btn btn-primary">Back</a>
    </div>
    <form wire:submit.prevent='update({{ $id_category }})'>
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error(" name") is-invalid @enderror" id="name"
                placeholder="Contoh : Elektronika" value="{{ old('name') }}" wire:model="name" required>
            <label for="name" class="required">Nama Category</label>
            @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" wire:model="deskripsi" id="deskription" style="height: 100px"></textarea>
            <label for="deskription">Comments</label>
            @error('deskripsi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="text-end">
            <div class="d-flex align-item-center justify-content-end">
                <div class="spinner-border text-primary mr-2" role="status" wire:loading wire:target="update">
                    <span class="sr-only">Loading...</span>
                </div>
                <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
        </div>
    </form>
    @endif
</div>