<div>
    <div class="card card-default color-palette-box p-3">
        <form>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="nama_barang" aria-describedby="emailHelp"
                        name="nama_barang" wire:model="nama_barang">
                    @error('nama_barang')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="kondisi" class="form-label">Kondisi</label>
                    <select class="form-select" aria-label="Default select example" name="kondisi" wire:model="kondisi">
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
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 col-md-12">
                    <label for="foto" class="form-label">Foto Dokumentasi</label>
                    <input class="form-control" type="file" id="foto" name="foto" wire:ignore
                        wire:model="foto">
                    @error('foto')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-primary">Sumbit</button>
            </div>
        </form>
    </div>
</div>
