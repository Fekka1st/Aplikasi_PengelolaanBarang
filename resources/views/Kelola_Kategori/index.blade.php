@extends('layouts.app')
@section('title', 'Kategori Barang')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Kelola Kategori </h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <h4>Kelola Kategori  </h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addkategoriModal">
                            Tambah Kategori
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
                                                <th>Nama Kategori</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($kategori as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->nama_kategori }}</td>
                                                <td class="text-center">
                                                    <button type="button"
                                                    class="btn btn-warning btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editkategoriModal"
                                                    onclick="editKategori({{ $item->id }})">
                                                    Edit
                                                    </button>
                                                    @method('DELETE')
                                                    <a href="{{route('Kategori.destroy', $item->id)}}" class="btn btn-sm btn-danger" data-confirm-delete="true">Hapus</a>
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
@include('Kelola_Kategori.add')
@include('Kelola_Kategori.edit')
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    function editKategori(id) {
        $.ajax({
            url: `/Kelola-Kategori/edit/${id}`,
            type: 'GET',
            success: function (data) {
                const form = document.getElementById('editForm');
                form.action = `/Kelola-Kategori/update/${data.id}`;
                form.method = 'POST';
                document.getElementById('edit_nama').value = data.nama_kategori;
                $('#editkategoriModal').modal('show');
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

