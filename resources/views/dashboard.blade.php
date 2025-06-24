@extends('layouts.app')
@section('title','Dashboard')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card shadow-sm h-100 border-start border-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title text-primary mb-0"><i class="bi bi-boxes me-2"></i>Total Barang</h5>
                            <span class="badge bg-primary-subtle text-primary-emphasis fs-6">{{$totalStokBarang}}</span>
                        </div>
                        <p class="card-text text-muted small">Jumlah keseluruhan barang tersedia di gudang.</p>
                        {{-- <a href="#" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail Inventaris</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100 border-start border-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title text-success mb-0"><i class="bi bi-box-arrow-in-down me-2"></i>Barang Masuk</h5>
                            <span class="badge bg-success-subtle text-success-emphasis fs-6">{{ $totalBarangMasuk}}</span>
                        </div>
                        <p class="card-text text-muted small">Kelola barang baru dan barang pinjaman masuk.</p>
                        <div class="mt-2">
                            <a href="{{route('Barang_Masuk.index')}}" class="btn btn-sm btn-success me-2">+Barang Baru</a>
                            {{-- <a href="#" class="btn btn-sm btn-outline-success">+ Barang Pinjam</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100 border-start border-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title text-danger mb-0"><i class="bi bi-box-arrow-up me-2"></i>Barang Keluar</h5>
                            <span class="badge bg-danger-subtle text-danger-emphasis fs-6">{{$totalBarangKeluar}}</span>
                        </div>
                        <p class="card-text text-muted small">Validasi dan proses permintaan barang keluar.</p>
                        <a href="{{route('Barang_Keluar.index')}}" class="btn btn-sm btn-danger mt-2">Proses Barang Keluar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i> Riwayat Transaksi Terbaru Hari ini</h5>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="recentTransactionsTable" class="table table-hover align-middle w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Serial Nomor</th>
                                        <th>Kategori</th>
                                        <th>Jumlah</th>
                                        <th>Tipe</th>
                                        <th>Staff</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                         @foreach($transaksi as $item)
                                            <tr>
                                                <td>{{ $item['kode_barang'] }}</td>
                                                <td>{{ $item['nama_barang'] }}</td>
                                                <td>{{ $item['serial_number'] }}</td>
                                                <td><span class="badge rounded-pill bg-light text-dark border">{{ $item['kategori'] }}</span></td>
                                                @if($item['tipe'] == 'Barang Masuk')
                                                    <td><span class="text-success fw-bold">+{{ $item['jumlah'] }}</span></td>
                                                    <td>
                                                        <span class="badge bg-success-subtle text-success-emphasis">
                                                            <i class="bi bi-arrow-down-circle me-1"></i>{{$item['tipe']}}
                                                        </span>
                                                    </td>
                                                @else
                                                    <td><span class="text-danger fw-bold">-{{ $item['jumlah'] }}</span></td>
                                                    <td>
                                                        <span class="badge bg-danger-subtle text-success-emphasis">
                                                            <i class="bi bi-arrow-up-circle me-1"></i>{{$item['tipe']}}
                                                        </span>
                                                    </td>
                                                @endif
                                                <td>{{ $item['staff'] }}</td>
                                                <td><small class="text-muted">{{ $item['waktu'] }}</small></td>
                                            </tr>
                                        @endforeach
                                    </tr>
                                 </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<style>
        /* Custom styles for professional look */
        body {
            background-color: #f8f9fa; /* Light grey background */
        }
        .card {
            border-radius: 0.75rem; /* Slightly rounded corners */
        }
        .card-header {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            font-weight: 600;
        }
        .table thead th {
            font-weight: 600;
            color: #495057; /* Darker grey for headers */
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background-color: #0d6efd !important; /* Bootstrap primary blue */
            border-color: #0d6efd !important;
            color: white !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #e2e6ea !important; /* Lighter hover for pagination */
            border-color: #dae0e5 !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.375rem; /* Match Bootstrap input style */
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
        }
        .dataTables_wrapper .dataTables_length select {
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
        }
    </style>
@endpush
@push('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> bikin error --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script>
        $(document).ready(function() {
            $('#recentTransactionsTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json"
                }
            });
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
</script>
@endpush
