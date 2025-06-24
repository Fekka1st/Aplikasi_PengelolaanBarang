<div class="modal fade" id="EditJenisModal" tabindex="-1" aria-labelledby="EditTimLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="EditTimLabel">Form Edit Jenis</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST') {{-- akan diubah via JS --}}
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama Jenis</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" aria-describedby="nama"
                            placeholder="Masukkan Nama Jenis" required>
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
