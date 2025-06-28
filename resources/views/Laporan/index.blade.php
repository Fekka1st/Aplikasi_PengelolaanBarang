@extends('layouts.app')
@section('title','Laporan')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold">Laporan </h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <h4 class="card-title">Filter Laporan Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="GET">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="jenis" class="form-label">Jenis Transaksi Barang<span class="text-danger">*</span></label>
                                    <select name="jenis" id="jenis" class="form-select select2-single @error('jenis') is-invalid @enderror" autocomplete="off" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Barang-Keluar" {{ old('jenis', request('jenis')) == 'Barang-Keluar' ? 'selected' : '' }}>Barang Keluar</option>
                                        <option value="Barang-Masuk" {{ old('jenis', request('jenis')) == 'Barang-Masuk' ? 'selected' : '' }}>Barang Masuk</option>
                                        <option value="Total-Stok" {{ old('jenis', request('jenis')) == 'Total-Stok' ? 'selected' : '' }}>Total Stok Barang</option>

                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="tgl_awal" class="form-label">Tanggal Awal</label>
                                    <input type="date" name="tgl_awal" id="tgl_awal" class="form-control @error('tgl_awal') is-invalid @enderror"
                                        value="{{ old('tgl_awal', request('tgl_awal')) }}" placeholder="Tanggal awal" autocomplete="off" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="tgl_akhir" class="form-label">Tanggal Akhir</label>
                                    <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control @error('tgl_akhir') is-invalid @enderror"
                                        value="{{ old('tgl_akhir', request('tgl_akhir')) }}" placeholder="Tanggal akhir" autocomplete="off" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if($jenis == 'Barang-Keluar')
            @include('Laporan.BarangKeluar')
        @elseif($jenis == 'Barang-Masuk')
            @include('Laporan.BarangMasuk')
        @elseif($jenis == 'Total-Stok')
            @include('Laporan.TotalStok')
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

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

