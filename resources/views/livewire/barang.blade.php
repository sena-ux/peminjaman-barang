<div>
    <div class="content-header p-3">
        <div class="content-header card my-2 p-2 px-3"
            style="display: flex; justify-content: space-between; align-items: center; width: 100%; flex-direction: row">
            <div>
                <h1 class="mt-1">Barang</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Barang Management</li>
                    <li class="breadcrumb-item active">Barang</li>
                </ol>
            </div>
            <div>
                @yield('action')
                {{-- <a wire:click='create' class="btn btn-outline-primary rounded-pill"><i
                        class="fa-solid fa-plus px-1"></i>Create New
                    Admin</a> --}}
            </div>
        </div>
    </div>

    <div class="card card-default color-palette-box">
        Hallo
    </div>
</div>