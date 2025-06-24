@extends('layouts.app')
@section('title', 'Manajemen Barang')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Kelola Pengguna</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <h4>Kelola Pengguna </h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPenggunaModal">
                            Tambah Pengguna
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-hover table-sales">
                                    <table class="table table-bordered table-striped"id="example">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th class="text-center">Foto</th>
                                                <th>Nama Pengguna</th>
                                                <th>Email</th>
                                                <th>No Telp</th>
                                                <th>Role</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pengguna as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-center">
                                                    <img
                                                        src="{{ $item->foto ? asset('storage/' . $item->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($item->name) }}"
                                                        alt="Foto Profil"
                                                        class="rounded-circle shadow-sm"
                                                        width="100"
                                                        height="100">
                                                </td>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>{{$item->no_telp}}</td>
                                                <td>{{$item->role ? 'HR' : 'Staff'}}</td>
                                                <td class="text-center">
                                                    <button type="button"
                                                    class="btn btn-warning btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#EditTimLapangan"
                                                    onclick="editKategori({{ $item->id }})">
                                                    Edit
                                                    </button>
                                                    @method('DELETE')
                                                    <a href="{{route('Pengguna.destroy', $item->id)}}" class="btn btn-sm btn-danger" data-confirm-delete="true">Hapus</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('Kelola_Pengguna.add')
@include('Kelola_Pengguna.edit')
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.querySelector('.toggle-password');
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('iconPassword');

        toggleBtn.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ganti icon
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    });
</script>
<script>
    function editKategori(id) {
        $.ajax({
            url: `/Kelola-Pengguna/edit/${id}`,
            type: 'GET',
            success: function (data) {
                // Set form action
                const form = document.getElementById('editForm');
                form.action = `/Kelola-Pengguna/update/${data.id}`;
                form.method = 'POST';
                // Isi field form
                document.getElementById('edit_nama').value = data.name;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_no_telp').value = data.no_telp;
                document.getElementById('edit_role').value = data.role;
                // Tampilkan modal
                $('#EditPenggunaModal').modal('show');
            },
            error: function () {
                alert('Gagal mengambil data.');
            }
        });
    }
</script>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            responsive: true,
            lengthMenu: [5, 10, 25, 50, 100],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Selanjutnya"
                },
                zeroRecords: "Data tidak ditemukan",
                infoEmpty: "Tidak ada data yang ditampilkan",
                infoFiltered: "(difilter dari _MAX_ total data)"
            }
        });
    });
</script>
@endpush
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

