@extends('admin/layouts/main')
@section('nameAplication', 'Kerusakan Umum')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active"><a href="{{route('permission.index')}}">Permission</a></li>
<li class="breadcrumb-item active">Asign Permission To Model</li>
@section('action')
<a wire:click='$set("page", "index")' class="btn btn-primary">Kembali</a>
@endsection
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <div class="row">
                <caption>List of Asign To Model.</caption>
                <table class="table table-dark dataTableResponsive">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Guard Name</th>
                            <th scope="col">Permission</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->guard_name }}</td>
                            <td>
                                <ul>
                                    @forelse ($role->getAllPermissions() as $key => $item)
                                    <li>{{ $item->name }}</li>
                                    @empty
                                    <li>Not Give Permissions!</li>
                                    @endforelse
                                </ul>
                            </td>
                            <td>
                                <a href="{{route('asignToModel.edit', $role->id)}}" class="btn btn-info">Asign
                                    Permision</a>
                                <a class="btn btn-danger" data-toggle="modal"
                                    data-target="#deleterole{{$role->id}}">Delete
                                    Permission</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection