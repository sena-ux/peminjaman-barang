@extends('admin/layouts/main')
@section('nameAplication', 'Siswa')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">User Manajement</li>
<li class="breadcrumb-item active">Siswa</li>
@endsection
    <section class="content">
        <div class="container-fluid">
            {!! $dataTable->table([
                'class' => 'table table-bordered table-striped bg-dark text-dark',
            ]) !!}
        </div>
    </section>
    @push('js')
    <script src="{{asset('script/siswa/ajax.js')}}"></script>
    {!! $dataTable->scripts() !!}
    @endpush
@endsection