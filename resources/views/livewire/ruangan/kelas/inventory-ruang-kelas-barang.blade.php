<div>
    <div class="card card-default color-palette-box p-3 create-inventoryBRK" id="createInventoryForm"
        style="display: none;">
        <form class="row g-3 needs-validation" novalidate wire:submit="store">
            <p class="text-center">Insert Data Barang</p>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                        id="nama_barang" aria-describedby="emailHelp" name="nama_barang" wire:model="nama_barang"
                        required>
                    @error('nama_barang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Wajib di sini, minlength 8.
                    </div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="kondisi" class="form-label">Kondisi</label>
                    <select class="form-select @error('kondisi') is-invalid @enderror"
                        aria-label="Default select example" name="kondisi" wire:model="kondisi" required>
                        <optgroup label="Kondisi Barang">
                            <option selected>Choose....</option>
                            @forelse ($setKondisi as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @empty
                                <option selected></option>
                            @endforelse
                        </optgroup>
                    </select>
                    @error('kondisi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Kolom ini wajib di isi.
                    </div>
                </div>

                <div class="mb-3 col-md-12">
                    <label for="foto" class="form-label">Foto Dokumentasi</label>
                    <input accept=".jpg,.jpeg,.png,.PNG,.JPG,.JPEG"
                        class="form-control @error('foto') is-invalid @enderror" type="file" id="foto"
                        name="foto" wire:model="foto" required>
                    @error('foto')
                        <div class="invalid-feedback">
                            Harus format gambar dan berukuran maksimal 2MB.
                        </div>
                    @enderror

                    @if ($foto)
                        <img src="{{ $foto->temporaryUrl() }}" class="rounded p-2 my-2" style="width: 200px">
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-primary" id="submitBtn">Sumbit</button>
                <button class="btn btn-primary d-none" id="loadingBtn" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Loading...</span>
                </button>
            </div>

        </form>
    </div>

    <div class="card card-default color-palette-box">
        @role('siswa')
            <a class="btn newdt btn-primary col-md-2 m-2" id="newInventoryRK" onclick="Create(this)">
                <i class="fas fa-plus m-2"></i><span id="toggleText">New</span>
            </a>
        @endrole
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kode Barang</th>
                        <th>Kondisi</th>
                        <th>Status Pengerjaan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <p>Tidak ada data yanng di temukan!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @role('siswa')
        <a class="fs-1 newmb" onclick="Create(this)"><i class="fas fa-plus-octagon fa-lg"></i></a>
    @endrole
    @push('js')
        <script>
            function Create(button) {
                var form = document.getElementById('createInventoryForm');
                var toggleText = button.querySelector('#toggleText') ?? "";
                var icon = button.querySelector('i');

                if (form.style.display === "none") {
                    form.style.display = "block";
                    toggleText.textContent = "Close Create" ?? "";
                    button.classList[1] == 'newdt' ? icon.classList.remove('fa-plus') : icon.classList.remove(
                        'fa-plus-octagon');
                    button.classList[1] == 'newdt' ? icon.classList.add('fa-minus') : icon.classList.add('fa-minus-octagon');
                } else {
                    form.style.display = "none";
                    toggleText.textContent = "New";
                    button.classList[1] == 'newdt' ? icon.classList.remove('fa-minus') : icon.classList.remove(
                        'fa-minus-octagon');
                    button.classList[1] == 'newdt' ? icon.classList.add('fa-plus') : icon.classList.add('fa-plus-octagon');
                }
            };

            (() => {
                'use strict'
                const forms = document.querySelectorAll('.needs-validation')
                Array.from(forms).forEach(form => {
                    const submitButton = form.querySelector('button[type="submit"]')
                    submitButton.disabled = true

                    form.addEventListener('input', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                            submitButton.disabled = true
                        } else {
                            submitButton.disabled = false
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            })()


            document.addEventListener('livewire:submit', function() {
                // Menampilkan tombol loading dan menyembunyikan tombol submit
                document.getElementById('submitBtn').classList.add('d-none'); // Sembunyikan tombol submit
                document.getElementById('loadingBtn').classList.remove('d-none'); // Tampilkan tombol loading
            });

            document.addEventListener('livewire:load', function() {
                Livewire.on('submitted', () => {
                    // Mengembalikan tombol ke keadaan semula setelah berhasil
                    document.getElementById('loadingBtn').classList.add('d-none'); // Sembunyikan tombol loading
                    document.getElementById('submitBtn').classList.remove(
                    'd-none'); // Tampilkan tombol submit kembali
                });
            });
        </script>
    @endpush
</div>
