@extends('layouts.app')
@section('title', 'Pengaturan Profil')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-person-gear me-2"></i>Pengaturan Profil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Foto Profil -->
                        <div class="mb-4 text-center">
                        <img
                        src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                        class="rounded-circle shadow-sm"
                        width="100"
                        height="100"
                        alt="Foto Profil">
                            <div class="mt-2">
                                <input type="file" name="profile_photo" class="form-control form-control-sm" accept="image/*">
                            </div>
                        </div>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', Auth::user()->no_telp) }}">
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password Baru <span class="text-muted">(Opsional)</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

