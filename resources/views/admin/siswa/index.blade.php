@extends('admin/layouts/main')
@section('nameAplication', 'Siswa')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">
            <livewire:User.Siswa>
        </div>
    </div>
</section>
@endsection