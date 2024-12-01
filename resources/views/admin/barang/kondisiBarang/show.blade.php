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
            <div class="table-responsive border-bottom border-light">
                <table class="table table-bordered dataTableResponsive">
                    <thead>
                        <tr>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Ruangan</th>
                            <th scope="col">Kode Barang</th>
                            <th scope="col">Created</th>
                            <th scope="col">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $inv_barang->barang->nama_barang }}</td>
                            <td>{{ $inv_barang->ruangan->nama_ruangan }}</td>
                            <td>{{ $inv_barang->kode_barang }}</td>
                            <td>{{ $inv_barang->tanggal }}
                            </td>
                            <td>{{ $inv_barang->updated_at . '|' . $inv_barang->updated_at->diffForHumans() }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="text-end py-2">
                <a data-toggle="modal" data-target="#create-kondisi-barang" class="btn btn-primary">Create Kondisi
                    Barang</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered dataTableResponsive">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Kondisi</th>
                            <th scope="col">Status Barang</th>
                            <th scope="col">Detail Kerusakan</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kondisiBarangs as $item)
                        <tr>
                            <td class="align-middle">{{ $item->date }}</td>
                            <td class="align-middle">{{ $item->kondisi }}</td>
                            <td class="align-middle">{{ $item->status_barang }}</td>
                            <td>
                                <a data-bs-toggle="modal" data-bs-target="#detailKerusakan{{$item->id}}"
                                    class="btn btn-primary">Show Detail Kerusakan
                                </a>
                            </td>
                            <td class="align-middle">
                                {{-- <a class="btn btn-info m-1" data-toggle="modal"
                                    data-target="#edit-kondisi-barang">Edit</a> --}}
                                <a class="btn btn-danger m-1" data-toggle="modal"
                                    data-target="#delete-kondisi-barang{{$item->id}}">Delete</a>
                            </td>
                        </tr>

                        <!-- Modal Show Images -->
                        <div class="modal fade" id="detailKerusakan{{$item->id}}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailKerusakan{{$item->id}}Label"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailKerusakan{{$item->id}}Label">Detail Kerusakan
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {!! $item->detail_kondisi !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Delete Kondisi Barang -->
                        <div class="modal fade" id="delete-kondisi-barang{{$item->id}}" tabindex="-1"
                            aria-labelledby="delete-kondisi-barangLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{route('kondisiBarang.destroy', $item->id)}}" method="POST">
                                        @method("DELETE")
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title text-danger" id="delete-kondisi-barangLabel">
                                                Delete Kondisi {{$item->inventory->barang->nama_barang ?? 'Barang'}}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Delete Kondisi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create Kondisi Barang -->
    <div class="modal fade" id="create-kondisi-barang" tabindex="-1" aria-labelledby="create-kondisi-barangLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="create-kondisi-barangLabel">Create New Kondisi
                        {{$inv_barang->barang->nama_barang}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('kondisiBarang.store')}}" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <input type="hidden" name="inv_brg_id" value="{{$inv_barang->id}}">
                            <div class="col-4">
                                <label for="date">Tanggal</label>
                                <input type="date" name="date" id="date" class="form-control">
                            </div>
                            <div class="col-4">
                                <label for="kondisi" class="required">Kondisi</label>
                                <select class="custom-select" name="kondisi" id="kondisi" required>
                                    <option value="" selected>Open this select Kondisi</option>
                                    <optgroup label="List Kondisi">
                                        @forelse ($kondisi as $item)
                                        <option value="{{$item['name']}}">{{ $item['name'] }}</option>
                                        @empty
                                        <option value="" disabled>No Data</option>
                                        @endforelse
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="status" class="required">Status</label>
                                <select class="custom-select" name="status" id="status" required>
                                    <option value="" selected>Open this select Status</option>
                                    <optgroup label="List Ststuas">
                                        @forelse ($status as $item)
                                        <option value="{{$item['name']}}">{{ $item['name'] }}</option>
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
                                <textarea name="detail_kondisi" style="height: 100%;" id="detail" cols="100" rows="10"
                                    class="tinyMce fullAccess">
                                    <h1 style="text-align: center;">Detail Kerusakan</h1>
                                    <caption>Detail Kerusakan</caption>
                                    <table border="1" class="table table-bordered" style="width: 100%; table-layout: fixed; word-wrap: break-word; border-collapse: collapse;">
                                        <tr>
                                            <td style="width: 30%;">Kronologi Kerusakan</td>
                                            <td style="width: 70%; "> </td>
                                        </tr>
                                        <tr>
                                            <td>Deskripsi singkat </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Apa saja yang rusak </td>
                                            <td>
                                                <ol>
                                                    <li></li>
                                                </ol>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal </td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Lokasi </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Ruangan </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Foto Kerusakan </td>
                                            <td></td>
                                        </tr>
                                        @can('perbaikan kerusakan')
                                        <tr>
                                            <td colspan="2" style="text-align: center;" contenteditable="true">Disini saat perbaikan di lakukan.</td>
                                        </tr>
                                        <tr>
                                            <td>Perbaikian </td>
                                            <td>
                                                <ul>
                                                    <li></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal </td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Foto Sebelum </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Foto Sesudah </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Foto Dalam Pengerjaan </td>
                                            <td></td>
                                        </tr>
                                        @endcan
                                    </table>
                                </textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="create-kondisi" hidden></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"
                        onclick="document.getElementById('create-kondisi').click()">Create New Kondisi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Kondisi Barang -->
    <div class="modal fade" id="edit-kondisi-barang" tabindex="-1" aria-labelledby="edit-kondisi-barangLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="edit-kondisi-barangLabel">Update Kondisi
                        {{$inv_barang->barang->nama_barang}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('create-kondisi-barang')}}" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <input type="hidden" name="inv_brg_id" value="{{$inv_barang->id}}">
                            <div class="col-md-6 p-2">
                                <label for="date">Tanggal</label>
                                <input type="date" name="date" id="date" class="form-control">
                            </div>
                            <div class="col-md-6 p-2">
                                <label for="kondisi" class="required">Kondisi</label>
                                <select class="custom-select" name="kondisi" id="kondisi" required>
                                    <option value="" selected>Open this select Kondisi</option>
                                    <optgroup label="List Kondisi">
                                        @forelse ($kondisi as $item)
                                        <option value="{{$item['name']}}">{{ $item['name'] }}</option>
                                        @empty
                                        <option value="" disabled>No Data</option>
                                        @endforelse
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-6 p-2">
                                <label for="status" class="required">Status</label>
                                <select class="custom-select" name="status" id="status" required>
                                    <option value="" selected>Open this select Status</option>
                                    <optgroup label="List Ststuas">
                                        @forelse ($status as $item)
                                        <option value="{{$item['name']}}">{{ $item['name'] }}</option>
                                        @empty
                                        <option value="" disabled>No Data</option>
                                        @endforelse
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-6 p-2">
                                <label for="images" class="required">Upload Images</label>
                                <input type="file" name="images" id="images" class="form-control"
                                    accept=".png,.jpg,.jpeg">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="create-kondisi" hidden></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Delete
                        Kondisi</button>
                </div>
            </div>
        </div>
    </div>
</section>
@push('js')
@endpush
@endsection