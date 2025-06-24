<div class="modal fade" id="addBarangMasukModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah Barang Masuk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('Barang_Masuk.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="nama_barang">Nama Barang</label>
                            <select name="nama_barang" id="inputnama_barang" class="form-select w-100" required>
                                <option value="" disabled selected>Pilih Nama Barang</option>
                                @foreach ($list_barang as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->kode_barang }} - {{ $item->nama_barang }} - {{ $item->serial_number }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted">Format: Kode Barang - Nama Barang - Serial Number</span>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" aria-describedby="keterangan" required>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>




