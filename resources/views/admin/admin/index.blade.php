@extends('admin/layouts/main')
@section('nameAplication', 'Admin')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">User Manajement</li>
<li class="breadcrumb-item active">Admin</li>
@endsection
@section('action')
<a href="{{ route('admin.create') }}" class="btn btn-outline-primary rounded-pill"><i
        class="fa-solid fa-plus px-1"></i>Create New
    Admin</a>
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            {{-- <div class="d-flex justify-content-between">
                <div class="">
                    <label for="">Page : </label>
                    <select name="select" id="">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="40">40</option>
                    </select>
                </div>
                <div class="filter">
                    <a href="#/filter" class="text-decoration-none text-light">
                        <i class="fa-solid fa-filter"></i>
                    </a>
                </div>
            </div> --}}
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
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $key => $admin)
                    <tr>
                        <th scope="row">{{ $admins->firstItem() + $key }}</th>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->user->email }}</td>
                        <td>{{ $admin->user->username }}</td>
                        <td>{{ $admin->alamat ?? "-" }}</td>
                        <td>{{ $admin->no_hp ?? "-" }}</td>
                        <td>{{ $admin->gender ?? "-" }}</td>
                        <td>
                            <a href="{{ route('admin.show', $admin->id) }}" class="btn btn-info">Show</a>
                            <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-primary">Edit</a>
                            <a class="btn btn-danger" data-toggle="modal" data-target="#deleteAdmin">Delete</a>
                        </td>
                    </tr>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteAdmin" tabindex="-1" aria-labelledby="deleteAdminLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="deleteAdminLabel">Yakin delete admin dengan
                                        username : {{ $admin->user->username }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer text-end">
                                    <form action="{{route('admin.destroy', $admin->user->id)}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                    <button type="submit" class="btn btn-danger">Delete {{ $admin->user->username
                                        }}</button>
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
                {{ $admins->links() }}
            </div>
        </div>
    </div>
</section>
@endsection