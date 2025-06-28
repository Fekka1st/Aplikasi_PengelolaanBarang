        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <h4>Daftar Laporan Total Barang </h4>
                        </div>
                        <div>
                             <a href="{{ route('laporan.totalstok.export', [
                                'tgl_awal'  => request('tgl_awal'),
                                'tgl_akhir' => request('tgl_akhir'),
                            ]) }}" class="btn btn-success mb-3">
                            <i class="fas fa-file-excel"></i> Export Excel
                            </a>
                        </div>
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
                                                <th>Serial Nomor</th>
                                                <th>Kategori Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Stok Barang</th>
                                                <th>Tanggal</th>
                                                <th>Di Input Oleh</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->kode_barang }}</td>
                                                <td>{{ $item->serial_number}}</td>
                                                <td>{{ $item->kategori->nama_kategori }}</td>
                                                <td>{{ $item->nama_barang }}</td>
                                                <td>{{ $item->stok }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->pengguna->name }}</td>
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
