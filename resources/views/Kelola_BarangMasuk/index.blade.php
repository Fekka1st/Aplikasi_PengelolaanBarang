@extends('layouts.app')
@section('title', 'Kelola Barang Masuk')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Kelola Barang Masuk</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <h4>Kelola Barang Masuk </h4>
                        @if (Auth::user()->role == 0)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBarangMasukModal">
                            Tambah Barang Masuk
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
                                                <th class="text-center">QR Code</th>
                                                <th>Kode Transaksi</th>
                                                <th>Nama Barang</th>
                                                <th class="text-center">Jumlah</th>
                                                <th>Staff Input</th>
                                                <th>Tanggal</th>
                                                @if (Auth::user()->role == 0)
                                                <th class="text-center">Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($barang_masuk as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-center">
                                                    <img src="{{ asset('storage/' . $item->qr_code) }}" alt="QR Code" width="100" id="qr-img-{{ $item->id }}">
                                                        <br>
                                                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="downloadQR('{{ asset('storage/' . $item->qr_code) }}', '{{ $item->kode_transaksi }}')">
                                                            <i class="bi bi-download"></i> Unduh PNG
                                                        </button>
                                                </td>
                                                <td>{{ $item->kode_transaksi}}</td>
                                                <td>{{ $item->barang->nama_barang ?? 'Barang Tidak Ditemukan' }}</td>
                                                <td class="text-center"><span class="text-success fw-bold">+{{ $item->jumlah}}</span>
                                                     {{-- <span class="badge bg-success-subtle text-success-emphasis">
                                                <i class="bi bi-arrow-down-circle me-1"></i>Masuk
                                            </span> --}}
                                                </td>
                                                <td>{{ $item->staff->name}}</td>
                                                <td>{{ $item->created_at}}</td>
                                                @if (Auth::user()->role == 0)
                                                <td class="text-center">
                                                    <button type="button"
                                                    class="btn btn-warning btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#EditBarangMasuk"
                                                    onclick="editBarangMasuk({{ $item->id }})">
                                                    Edit
                                                    </button>
                                                    @method('DELETE')
                                                    <a href="{{route('Barang_Masuk.destroy', $item->id)}}" class="btn btn-sm btn-danger" data-confirm-delete="true">Hapus</a>
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
@include('Kelola_BarangMasuk.edit')
@include('Kelola_BarangMasuk.add')
@endif

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> {{-- jQuery dulu --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
function downloadQR(svgUrl, filename) {
    fetch(svgUrl)
        .then(res => res.text())
        .then(svgText => {
            const svg = new Blob([svgText], {type: 'image/svg+xml'});
            const DOMURL = self.URL || self.webkitURL || self;
            const url = DOMURL.createObjectURL(svg);

            const img = new Image();
            img.onload = function () {
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                DOMURL.revokeObjectURL(url);

                const pngImg = canvas.toDataURL('image/png');

                const a = document.createElement('a');
                a.href = pngImg;
                a.download = filename + '.png';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            };
            img.src = url;
        });
}
</script>

<script>
    $('#inputnama_barang').select2({
        placeholder: "Cari nama/kode/serial barang...",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#addBarangMasukModal') // Ganti sesuai ID modal kamu
    });
</script>
@if (Auth::user()->role == 0)
<script>
    function editBarangMasuk(id) {
        $.ajax({
            url: `/Kelola_Barang_Masuk/edit/${id}`,
            type: 'GET',
            success: function (data) {
                // Set form action
                console.log(data);
                const form = document.getElementById('editForm');
                form.action = `/Kelola_Barang_Masuk/update/${data.id}`;
                form.method = 'POST';
                document.getElementById('edit_inputnama_barang').value = data.barang_id;
                document.getElementById('edit_jumlah').value = data.jumlah;

                $('#EditBarangMasuk').modal('show');
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

