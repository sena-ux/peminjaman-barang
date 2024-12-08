<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak KIR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        *{
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header text-center">
            <img src="{{asset($kir_one->setting->kop_sekolah)}}" alt="" srcset="" class="img-fluid" width="300" height="200">
            <br>
            <h4>KARTU INVENTARIS RUANGAN (KIR)</h4>
        </div>
        <div class="row">
            <div class="col-md-2">Provinsi</div>: {{Str::ucfirst($kir_one->setting->provinsi)}}
        </div>
        <div class="row">
            <div class="col-md-2">Kabupaten/Kota</div>: {{Str::ucfirst($kir_one->setting->kabupaten)}}
        </div>
        <div class="row">
            <div class="col-md-2">Unit</div>: {{$kir_one->setting->unit}}
        </div>
        <div class="row">
            <div class="col-md-2">Kelas</div>: {{$kir_one->ruangan->kelas->name}}
        </div>
        <div class="row">
            <div class="col-md-2">Ruangan</div>: {{$kir_one->ruangan->nama_ruangan}}
        </div>
        <div class="row">
            <div class="col-md-2">Kode Ruangan</div>: {{$kir_one->ruangan->kode_ruangan}}
        </div>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2" class="align-middle">No</th>
                <th rowspan="2" class="align-middle">Nama Barang</th>
                <th rowspan="2" class="align-middle">Merk/Model</th>
                <th rowspan="2" class="align-middle">No Seri Pubrik</th>
                <th rowspan="2" class="align-middle">Ukuran</th>
                <th rowspan="2" class="align-middle">Bahan</th>
                <th rowspan="2" class="align-middle">Tahun Pengadaan</th>
                <th rowspan="2" class="align-middle">Kode Barang</th>
                <th rowspan="2" class="align-middle">Tahun Barang Register</th>
                <th rowspan="2" class="align-middle">Satuan</th>
                <th rowspan="2" class="align-middle">Harga Beli</th>
                <th colspan="5" class="align-middle">Keadaan Barang</th>
                <th rowspan="2" class="align-middle">Keterangan</th>
            </tr>
            <tr>
                <th class="align-middle">B</th>
                <th class="align-middle">KB</th>
                <th class="align-middle">RB</th>
                <th class="align-middle">T</th>
                <th class="align-middle">P</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kir as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{$item->barang->nama_barang}}</td>
                <td>{{$item->barang->merk}}</td>
                <td>{{$item->barang->no_seri_pubrik}}</td>
                <td>{{$item->barang->ukuran}}</td>
                <td>{{$item->barang->bahan}}</td>
                <td>{{$item->barang->tahun_pengadaan}}</td>
                <td>{{$item->barang->kode_barang}}</td>
                <td>{{$item->barang->tahun_register}}</td>
                <td>{{$item->barang->satuan}}</td>
                <td>{{$item->barang->harga}}</td>
                <td>{{$item->riwayat->bagus}}</td>
                <td>{{$item->riwayat->kurang_bagus}}</td>
                <td>{{$item->riwayat->rusak_berat}}</td>
                <td>{{$item->riwayat->jumlah}}</td>
                <td>{{$item->riwayat->pindah ?? "0"}}</td>
                <td>{{$item->riwayat->keterangan}}</td>
            </tr>
            @empty
                <tr>
                    Data Kosong
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="row">
        <div class="col-4">
            <div class="text-center">
                <span>Mengetahui,</span><br>
                <span>Kepala {{ $kir_one->setting->unit }}</span>
                <br><br>
                <span class="text-decoration-underline"><b>{{ $kir_one->kepala_sekolah->name ?? "Tidak ada data kepala sekolah" }}</b></span><br>
                <span>NIP : {{ $kir_one->kepala_sekolah->nip ?? "-" }}</span>
            </div>
        </div>
        <div class="col-4">
            <div class="text-center">
                <span>Penanggung Jawab Ruangan</span><br>
                <span>Wali Kelas {{ $kir_one->ruangan->kelas->name }}</span>
                <br><br>
                <span class="text-decoration-underline"><b>{{ $kir_one->wali->name ?? "Tidak ada data Wali Kelas" }}</b></span><br>
                <span>NIP : {{ $kir_one->wali->nip ?? "-" }}</span><br><br>
                <span>Ketua Kelas</span>
                <br>
                <br>
                <span class="text-decoration-underline"><b>{{ $kir_one->wali->name ?? "Tidak ada data Ketua Kelas" }}</b></span><br>
            </div>
        </div>
        <div class="col-4">
            <div class="text-center">
                <span>Amlapura, {{ now()->format('d-m-Y') }}</span><br>
                <span>Pengelola Pemanfaatan BMD</span><br>
                <span>{{ $kir_one->setting->unit }}</span>
                <br><br>
                <span class="text-decoration-underline"><b>{{ $kir_one->pengelola->name ?? "Tidak ada data Pengelola" }}</b></span><br>
                <span>NIP : {{ $kir_one->pengelola->nip ?? "-" }}</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script>
        window.print()
    </script>
</body>

</html>