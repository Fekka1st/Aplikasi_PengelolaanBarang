<div class="modal fade" id="addBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah Barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('Manajemen_Barang.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Kategori Barang -->
                        <div class="col-md-12">
                            <label for="kategori_barang_id" class="form-label">Kategori Barang</label>
                            <select name="kategori_barang_id" id="kategori_barang_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach($kategoriBarangList as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                         <!-- Kode Barang -->
                        <div class="col-md-6">
                            <label for="kode_barang" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Contoh: BRG001" required>
                        </div>
                        <!-- Nama Barang -->
                        <div class="col-md-6">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang" required>
                        </div>

                        <!-- Serial Number -->
                        <div class="col-md-12">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="Masukkan Serial Number">
                        </div>
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




