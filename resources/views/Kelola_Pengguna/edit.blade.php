<div class="modal fade" id="EditPenggunaModal" tabindex="-1" aria-labelledby="EditTimLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="EditTimLabel">Form Edit Pengguna</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Nama -->
                        <div class="col-md-6">
                            <label for="edit_nama" class="form-label">Nama Pengguna</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" placeholder="Masukkan nama pengguna" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" placeholder="Masukkan email" required>
                        </div>

                        <!-- Password + toggle mata -->
                        <div class="col-md-6">
                            <label for="edit_password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="edit_password" name="password" placeholder="Kosongkan jika tidak ingin diubah">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye-slash" id="iconEditPassword"></i>
                                </button>
                            </div>
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>

                        <!-- No Telepon -->
                        <div class="col-md-6">
                            <label for="edit_no_telp" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="edit_no_telp" name="no_telp" placeholder="08xxxxxxxxxx" required>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6">
                            <label for="edit_role" class="form-label">Role</label>
                            <select class="form-select" id="edit_role" name="role" required>
                                <option value="" disabled selected>-- Pilih Role --</option>
                                <option value="0">HR</option>
                                <option value="1">Staff</option>
                            </select>
                        </div>

                        <!-- Foto -->
                        <div class="col-md-6">
                            <label for="edit_foto" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control" id="edit_foto" name="foto" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
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
