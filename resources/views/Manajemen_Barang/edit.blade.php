<div class="modal fade" id="EditBarangModal" tabindex="-1" aria-labelledby="EditTimLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="EditTimLabel">Form Edit Barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST') {{-- akan diubah via JS --}}
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Kategori Barang -->
                        <div class="col-md-12">
                            <label for="kategori_barang_id" class="form-label">Kategori Barang</label>
                            <select name="kategori_barang_id" id="edit_kategori_barang_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach($kategoriBarangList as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                         <!-- Kode Barang -->
                        <div class="col-md-6">
                            <label for="kode_barang" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" id="edit_kode_barang" name="kode_barang" placeholder="Contoh: BRG001" required>
                        </div>
                        <!-- Nama Barang -->
                        <div class="col-md-6">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="edit_nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang" required>
                        </div>

                        <!-- Serial Number -->
                        <div class="col-md-12">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="edit_serial_number" name="serial_number" placeholder="Masukkan Serial Number">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
