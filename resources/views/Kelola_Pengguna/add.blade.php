<div class="modal fade" id="addPenggunaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah Pengguna</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('Pengguna.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama Pengguna</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama pengguna" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" tabindex="-1">
                                    <i class="bi bi-eye-slash" id="iconPassword"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="no_telp" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="" disabled selected>-- Pilih Role --</option>
                                <option value="0">HR</option>
                                <option value="1">Staff</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
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




