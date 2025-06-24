@extends('layouts.app')
@section('title', 'Manajemen Barang')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Manajemen Barang</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <h4>Manajemen Barang </h4>
                        @if (Auth::user()->role == 0)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBarangModal">
                            Tambah Barang
                        </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-hover table-sales">
                                    <table class="table table-bordered table-striped"id="example">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Barang</th>
                                                <th>Nomor Serial</th>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th>Stok</th>
                                                <th>Staff Input</th>
                                                <th>Tanggal dan Waktu</th>
                                                @if (Auth::user()->role == 0)
                                                <th class="text-center">Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($barang as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{$item->kode_barang }}</td>
                                                <td>{{$item->serial_number}}</td>
                                                <td>{{$item->nama_barang}}</td>
                                                <td>{{$item->kategori->nama_kategori}}</td>
                                                <td>{{$item->stok}}</td>
                                                <td>{{$item->pengguna->name}}</td>
                                                <td>{{$item->created_at}}</td>
                                                @if (Auth::user()->role == 0)
                                                <td class="text-center">
                                                    <button type="button"
                                                    class="btn btn-warning btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#EditTimLapangan"
                                                    onclick="editKategori({{ $item->id }})">
                                                    Edit
                                                    </button>
                                                    @method('DELETE')
                                                    <a href="{{route('Manajemen_Barang.destroy', $item->id)}}" class="btn btn-sm btn-danger" data-confirm-delete="true">Hapus</a>
                                                </td>
                                                @endif
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
@if (Auth::user()->role == 0)
@include('Manajemen_Barang.add')
@include('Manajemen_Barang.edit')
@endif
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
@if (Auth::user()->role == 0)
<script>
    function editKategori(id) {
        $.ajax({
            url: `/Manajemen_Barang/edit/${id}`,
            type: 'GET',
            success: function (data) {
                // Set form action
                const form = document.getElementById('editForm');
                form.action = `/Manajemen_Barang/update/${data.id}`;
                form.method = 'POST';
                // Isi field form
                document.getElementById('edit_kategori_barang_id').value = data.kategori.id;
                document.getElementById('edit_kode_barang').value = data.kode_barang;
                document.getElementById('edit_nama_barang').value = data.nama_barang;
                document.getElementById('edit_serial_number').value = data.serial_number;
                // Tampilkan modal
                $('#EditBarangModal').modal('show');
            },
            error: function () {
                alert('Gagal mengambil data.');
            }
        });
    }
</script>
@endif

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

