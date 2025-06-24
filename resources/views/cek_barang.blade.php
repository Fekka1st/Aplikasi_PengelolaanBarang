<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Barang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl">

            <h1 class="text-2xl font-bold text-blue-600 mb-6 text-center">Cek Informasi Barang</h1>

            @if(isset($not_found) && $not_found)
                <div class="text-center text-red-500 font-semibold text-lg">
                    Data tidak ditemukan untuk kode transaksi yang dimasukkan.
                </div>
            @else
                <!-- Detail Barang -->
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="font-semibold">Kode Transaksi:</span>
                        <span>{{ $data->kode_transaksi }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-semibold">Kode Barang:</span>
                        <span>{{ $data->barang->kode_barang }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-semibold">Nama Barang:</span>
                        <span>{{ $data->barang->nama_barang }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-semibold">Serial Number:</span>
                        <span>{{ $data->barang->serial_number }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-semibold">Jumlah:</span>
                        <span>{{ $data->jumlah }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-semibold">Staff Input:</span>
                        <span>{{ $data->staff->name }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-semibold">Tipe:</span>
                        <span class="uppercase">
                            {{ $data instanceof \App\Models\barang_masuk ? 'Barang Masuk' : 'Barang Keluar' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold">Tanggal Dibuat:</span>
                        <span class="uppercase">
                            {{ $data->created_at}}
                        </span>
                    </div>
                </div>
            @endif

            <!-- Footer -->
            <div class="mt-6 text-center text-sm text-gray-500">
                © 2025 Sistem Pengelolaan Barang
            </div>
        </div>
    </div>

</body>
</html>
