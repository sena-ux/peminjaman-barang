<div>
    <div class="card card-default color-palette-box p-3 table-responsive">
        <div class="row">
            @if ($page == 'index')
            <div class="table-responsive">
                <table class="table table-bordered dataTableResponsive">
                    <thead>
                        <tr>
                            <th scope="col">Profile</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">NISN</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswas as $key => $siswa)
                        <tr>
                            <td class="align-middle"><img src="{{asset($siswa->foto)}}" alt="Icon Profile"
                                    class="img-fluid img-thumbnail" width="50"></td>
                            <td class="align-middle">{{ $siswa->name }}</td>
                            <td class="align-middle">{{ $siswa->kelas->name }}</td>
                            <td class="align-middle">{{ $siswa->nisn }}</td>
                            <td class="align-middle">
                                @role('petugas|admin|staf|superadmin')
                                <a wire:click='pinjamBarang({{$siswa->id}})' class="btn btn-info">Pinjam
                                    siswa</a>
                                @endrole
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
    <div class="card card-default color-palette-box p-3 table-responsive bg-warning">
        <div class="row">
            @if ($page == 'index')
            <div class="table-responsive">
                <caption>List yang <b>belum mengembalikan</b></caption>
                <table class="table table-bordered dataTableResponsive">
                    <thead>
                        <tr>
                            <th scope="col">Peminjam</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Penanggung Jawab</th>
                            <th scope="col">Keperluan</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamansBK as $key => $item)
                        <tr>
                            <td class="align-middle">{{ $item->user->siswa->name }}</td>
                            <td class="align-middle">{{ $item->barang->nama_barang }}</td>
                            <td class="align-middle">{{ $item->penanggung_jawab }}</td>
                            <td class="align-middle">{{ $item->keperluan }}</td>
                            <td class="align-middle">
                                @role('petugas|admin|staf|superadmin')
                                <a wire:click='' class="btn btn-info">Kembalikan</a>
                                @endrole
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
    <div class="card card-default color-palette-box p-3 table-responsive bg-success">
        <div class="row">
            @if ($page == 'index')
            <div class="table-responsive">
                <caption>List yang <b>sudah mengembalikan</b></caption>
                <table class="table table-bordered dataTableResponsive">
                    <thead>
                        <tr>
                            <th scope="col">Peminjam</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Penanggung Jawab</th>
                            <th scope="col">Keperluan</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamansSK as $key => $item)
                        <tr>
                            <td class="align-middle">{{ $item->user->siswa->name }}</td>
                            <td class="align-middle">{{ $item->barang->nama_barang }}</td>
                            <td class="align-middle">{{ $item->penanggung_jawab }}</td>
                            <td class="align-middle">{{ $item->keperluan }}</td>
                            <td class="align-middle">
                                @role('petugas|admin|staf|superadmin')
                                <a wire:click='' class="btn btn-info">Show</a>
                                @endrole
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>