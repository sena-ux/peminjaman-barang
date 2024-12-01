@extends('admin/layouts/main')
@section('nameAplication', 'Barang')
@section('content')
@section('linkLatest')
<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
<li class="breadcrumb-item active">Barang Management</li>
<li class="breadcrumb-item active">Barang</li>
@section('action')
<a href="{{route('inventory.index')}}" class="btn btn-primary">Kembali</a>
@endsection
@endsection
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box p-3 table-responsive">

            <form action="{{route('kondisiBarang.update', $kondisiBarang->id)}}" method="post" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-4">
                        <label for="date" class="required">Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{$kondisiBarang->date}}" required>
                    </div>
                    <div class="col-4">
                        <label for="kondisi" class="required">Kondisi</label>
                        <select class="custom-select" name="kondisi" id="kondisi" required>
                            <option value="">Open this select Kondisi</option>
                            <optgroup label="List Kondisi">
                                @forelse ($kondisi as $item)
                                <option value="{{$item['name']}}" @if ($kondisiBarang->kondisi == $item['name'])
                                    selected
                                @endif>{{ $item['name'] }}</option>
                                @empty
                                <option value="" disabled>No Data</option>
                                @endforelse
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="status" class="required">Status</label>
                        <select class="custom-select" name="status" id="status" required>
                            <option value="">Open this select Status</option>
                            <optgroup label="List Ststuas">
                                @forelse ($status as $item)
                                <option value="{{$item['name']}}"@if ($kondisiBarang->status_barang == $item['name'])
                                    selected
                                @endif>{{ $item['name'] }}</option>
                                @empty
                                <option value="" disabled>No Data</option>
                                @endforelse
                            </optgroup>
                        </select>
                    </div>
                    {{-- <div class="form-group">
                        <label for="images" class="required">Upload Images</label>
                        <input type="file" name="images" id="images" class="form-control"
                            accept=".png,.jpg,.jpeg,JPG,PNG,JPEG,.gif,.GIF">
                    </div> --}}
                    <div class="col-12">
                        <label for="detail">Detail Kondisi Barang</label>
                        <textarea name="detail_kondisi" style="height: 100vh;" id="detail" cols="100" rows="10"
                            class="tinyMce fullAccess">
                            {{ $kondisiBarang->detail_kondisi }}
                        </textarea>
                    </div>
                </div>
                <div class="text-end py-2">
                    <button type="submit" class="btn btn-primary" id="create-kondisi">Create Kondisi Barang</button>
                </div>
            </form>
        </div>
    </div>
</section>
@push('js')
@endpush
@endsection