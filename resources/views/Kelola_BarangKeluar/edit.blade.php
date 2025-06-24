<div class="modal fade" id="EditBarangMasuk" tabindex="-1" aria-labelledby="EditBarangMasuk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="EditBarangMasukLabel">Form Edit Barang Masuk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST') {{-- akan diubah via JS --}}
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="nama_barang">Nama Barang</label>
                            <select name="nama_barang" id="edit_inputnama_barang" class="form-select w-100" required>
                                <option value="" disabled selected>Pilih Nama Barang</option>
                                @foreach ($list_barang as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->kode_barang }} - {{ $item->nama_barang }} - {{ $item->serial_number }}
                                    </option>
                                @endforeach
                            </select>
                             <span class="form-text text-muted">Format: Kode Barang - Nama Barang - Serial Number</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jenis">Jenis Barang</label>
                            <select name="jenis" id="edit_jenis" class="form-select w-100" required>
                                <option value="" disabled selected>Pilih Jenis Barang</option>
                                @foreach ($list_jenis as $item)
                                    <option value="{{ $item->id }}">
                                       {{$item->nama_jenis}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="edit_jumlah" name="jumlah" aria-describedby="keterangan" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_penerima">Nama Penerima</label>
                            <input type="text" class="form-control" id="edit_nama_penerima" name="nama_penerima" aria-describedby="Nama Penerima" required>
                        </div>
                        <div class="form-group">
                            <label for="foto_penerima">Foto Penerima</label>
                            <input type="file" class="form-control" id="foto_penerima" name="foto_penerima">
                            <span class="form-text text-muted">*Bisa Kosongkan bila tidak ada perubahan</span>
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
