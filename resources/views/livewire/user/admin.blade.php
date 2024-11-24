<div>
    @if ($page == "show")
    @section('action')
    <a onclick="document.getElementById('create').click()" class="btn btn-outline-primary rounded-pill"><i
            class="fa-solid fa-plus px-1"></i>Create New
        Admin</a>
    @endsection
    @else
    @section('action')
    <a onclick="document.getElementById('back').click()" class="btn btn-outline-primary rounded-pill"><i
            class="fas fa-backward"></i>Back</a>
    @endsection
    @endif
    <button class="d-none" wire:click='create' id="create"></button>
    <button class="d-none" wire:click='back' id="back"></button>
    <div class="card card-default color-palette-box p-3 table-responsive">
        @if ($page == "show")
        <div class="d-flex justify-content-between">
            <div class="">
                <label for="">Page : </label>
                <select name="select" id="">
                    <option value="10" selected>10</option>
                    <option value="20" selected>20</option>
                    <option value="40" selected>40</option>
                </select>
            </div>
            <div class="filter">
                <a href="#/filter" class="text-decoration-none text-light">
                    <i class="fa-solid fa-filter"></i>
                </a>
            </div>
        </div>
        {{-- <caption>List of users Admin</caption> --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Username</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">No Hp</th>
                    <th scope="col">Gender</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admins as $key => $admin)
                <tr>
                    <th scope="row">{{ $admins->firstItem() + $key }}</th>
                    <td>{{ $admin->user->name }}</td>
                    <td>{{ $admin->user->email }}</td>
                    <td>{{ $admin->user->username }}</td>
                    <td>{{ $admin->alamat ?? "-" }}</td>
                    <td>{{ $admin->no_hp ?? "-" }}</td>
                    <td>{{ $admin->gender ?? "-" }}</td>
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="7">Tidak ada data terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @endif
        @if ($page == 'create')
        <div class="row">
            <div class="col-md-6">
                <div class="form-title">
                    <p>Authentication</p>
                    <hr>
                </div>
                <form action="">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInputDisabled"
                            placeholder="name@example.com" disabled>
                        <label for="floatingInputDisabled">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextareaDisabled"
                            disabled></textarea>
                        <label for="floatingTextareaDisabled">Comments</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2Disabled"
                            style="height: 100px" disabled>Disabled textarea with some text inside</textarea>
                        <label for="floatingTextarea2Disabled">Comments</label>
                    </div>
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelectDisabled"
                            aria-label="Floating label disabled select example" disabled>
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <label for="floatingSelectDisabled">Works with selects</label>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="form-title">
                    <p>Personal</p>
                    <hr>
                </div>
                <form action="">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInputDisabled"
                            placeholder="name@example.com" disabled>
                        <label for="floatingInputDisabled">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextareaDisabled"
                            disabled></textarea>
                        <label for="floatingTextareaDisabled">Comments</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2Disabled"
                            style="height: 100px" disabled>Disabled textarea with some text inside</textarea>
                        <label for="floatingTextarea2Disabled">Comments</label>
                    </div>
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelectDisabled"
                            aria-label="Floating label disabled select example" disabled>
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <label for="floatingSelectDisabled">Works with selects</label>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
    @push('js')
    {{-- <script>
        function checkHash() {
            const hash = window.location.hash;
            const show = document.getElementById('show');
            const createAdmin = document.getElementById('create');
            console.log(show)
            
            if (hash === '#/admin_create') {
                show.style.display = 'none';
                createAdmin.style.display = 'block';
            }
        }

        checkHash();

        window.addEventListener('hashchange', checkHash)
    </script> --}}
    @endpush
</div>