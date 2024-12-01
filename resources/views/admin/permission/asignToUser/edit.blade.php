@extends('admin/layouts/main')
@section('nameAplication', 'Kerusakan Umum')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active"><a href="{{route('permission.index')}}">Permission</a></li>
<li class="breadcrumb-item active">Asign Permission To Model</li>
@section('action')
<a href="{{route('role.index')}}" class="btn btn-primary">Kembali</a>
@endsection
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <form action="{{route('asignToUser.update', $role->id)}}" method="POST">
                @method('PATCH')
                @csrf
                @foreach ($permissions as $group => $groupPermissions)
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>{{ ucfirst($group) }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($groupPermissions as $permission)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input"
                                        id="permission_{{ $permission->id }}" name="permissions[]"
                                        value="{{ $permission->name }}" @if($role->hasPermissionTo($permission->name))
                                    checked @endif
                                    >
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="text-start p-2">
                    <a href="{{route('role.index')}}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update Permissions</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection