<?php

namespace App\Http\Controllers;

use App\Helpers\MessageHelper;
use App\Models\barang;
use App\Models\barang_keluar;
use App\Models\jenis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Kelola_BarangKeluarController extends Controller
{
    //

    public function index()
    {

        $title = 'Hapus Barang Masuk';
        $text = "Apakah Anda yakin ingin menghapus ini?";
        confirmDelete($title, $text);

        $barang_keluar = barang_keluar::with('barang','staff')->get();
        $list_jenis = jenis::all();
        $list_barang = barang::select('id','nama_barang','kode_barang','serial_number')->get();
        return view('Kelola_BarangKeluar.index',compact('barang_keluar','list_barang','list_jenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'nama_penerima' => 'required|string|max:255',
            'foto_penerima' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'jenis' => 'required|exists:jenis_barangs,id'
        ]);

        $barang = barang::findOrFail($request->nama_barang);

        if ($request->jumlah > $barang->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia. Stok saat ini: ' . $barang->stok . ' untuk barang ini: '.$barang->nama_barang);
        }

        $bulan = now()->format('m');
        $tahun = now()->format('Y');
        $prefix = "BRKLR-$bulan-$tahun";

        $last = barang_keluar::where('kode_transaksi', 'LIKE', "$prefix-%")
            ->orderBy('id', 'desc')
            ->first();

        $lastNumber = 0;
        if ($last && preg_match('/-(\d+)$/', $last->kode_transaksi, $matches)) {
            $lastNumber = (int) $matches[1];
        }

        $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $kodeTransaksi = "$prefix-$nextNumber";

        $linkCek = env('APP_URL') . "/cek-barang/" . $kodeTransaksi;

        $qrImage = QrCode::format('svg')->size(300)->generate($linkCek);
        $qrPath = "qr_codes/$kodeTransaksi.svg";
        Storage::disk('public')->put($qrPath, $qrImage);

        $pathFoto = null;
        if ($request->hasFile('foto_penerima')) {
            $pathFoto = $request->file('foto_penerima')->store('foto_penerima', 'public');
        }

        barang_keluar::create([
            'kode_transaksi' => $kodeTransaksi,
            'qr_code' => $qrPath,
            'jumlah' => $request->jumlah,
            'nama_penerima' => $request->nama_penerima,
            'foto_penerima' => $pathFoto,
            'barang_id' => $barang->id,
            'staff_id' => Auth::id(),
            'jenis_id' => $request->jenis,
        ]);


        $hrUsers = User::where('role', 1)->get();
        $kodeBarang = $barang->kode_barang ?? '-';
        $namaBarang = $barang->nama_barang ?? '-';
        $jumlah = $request->jumlah;
        foreach ($hrUsers as $hr) {
            $message = "Halo {$hr->name},\n\nTelah dilakukan *Pengurangan barang Keluar* dengan detail berikut:\n\n" .
                    "- Kode Barang: $kodeBarang\n" .
                    "- Nama Barang: $namaBarang\n" .
                    "- Jumlah: $jumlah\n" .
                    "- Nama Penerima Barang: $request->nama_penerima\n\n" .
                    "Silakan cek detailnya di sistem pengelolaan barang.\n\nTerima kasih.";
            try {
                MessageHelper::sendMessage($message, $hr->no_telp);
            } catch (\Exception $e) {

                Log::error("Gagal mengirim pesan ke {$hr->no_telp}: " . $e->getMessage());
                $errors[] = "Gagal mengirim notifikasi ke {$hr->name} ({$hr->no_telp})";
            }
        }
        if (!empty($errors)) {
            return back()->with('success', 'Data barang berhasil disimpan, namun ada notifikasi yang gagal dikirim.')
                        ->with('warning', implode("\n", $errors));
        }

        $barang->decrement('stok', $request->jumlah);

        return back()->with('success', 'Data Barang Keluar berhasil disimpan dan notifikasi berhasil dikirim..');
    }



    public function edit($edit){
        $barang = barang_keluar::with('barang','staff','jenis')->find($edit);
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'nama_penerima' => 'required|string|max:255',
            'foto_penerima' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'jenis' => 'required|exists:jenis_barangs,id'
        ]);

        $barangKeluar = barang_keluar::findOrFail($id);

        $oldJumlah = $barangKeluar->jumlah;
        $oldBarangId = $barangKeluar->barang_id;

        $oldBarang = barang::findOrFail($oldBarangId);
        $oldBarang->increment('stok', $oldJumlah);

        $newBarang = barang::findOrFail($request->nama_barang);
        if ($request->jumlah > $newBarang->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia. Stok saat ini: ' . $newBarang->stok . ' untuk barang ini: '.$newBarang->nama_barang);
        }
        $pathFoto = $barangKeluar->foto_penerima;
        if ($request->hasFile('foto_penerima')) {
            if ($pathFoto && Storage::disk('public')->exists($pathFoto)) {
                Storage::disk('public')->delete($pathFoto);
            }
            $pathFoto = $request->file('foto_penerima')->store('foto_penerima', 'public');
        }
        $barangKeluar->update([
            'barang_id' => $newBarang->id,
            'jumlah' => $request->jumlah,
            'nama_penerima' => $request->nama_penerima,
            'foto_penerima' => $pathFoto,
            'staff_id' => Auth::id(),
            'jenis_id' => $request->jenis,
        ]);
        $newBarang->decrement('stok', $request->jumlah);

        $hrUsers = User::where('role', 1)->get();
        $errors = [];

        foreach ($hrUsers as $hr) {
            $message = "Halo {$hr->name},\n\nData barang masuk telah *diperbarui* dengan detail:\n\n" .
                    "- Kode Transaksi: {$barangKeluar->kode_transaksi}\n" .
                    "- Kode Barang: {$newBarang->kode_barang}\n" .
                    "- Nama Barang: {$newBarang->nama_barang}\n" .
                    "- Jumlah Baru: {$request->jumlah}\n\n" .
                    "Silakan cek perubahan di sistem.\n\nTerima kasih.";

            try {
                MessageHelper::sendMessage($message, $hr->no_telp);
            } catch (\Exception $e) {
                Log::error("Gagal kirim notifikasi edit ke {$hr->no_telp}: {$e->getMessage()}");
                $errors[] = "Gagal kirim ke {$hr->name} ({$hr->no_telp})";
            }
        }

        if (!empty($errors)) {
            return back()->with('success', 'Data berhasil diperbarui, namun ada notifikasi yang gagal dikirim.')
                        ->with('warning', implode("\n", $errors));
        }

        return back()->with('success', 'Data Barang Keluar berhasil diperbarui.');
    }


   public function destroy($id)
    {
        $barangKeluar = barang_keluar::findOrFail($id);

        $barang = barang::findOrFail($barangKeluar->barang_id);
        $barang->increment('stok', $barangKeluar->jumlah);


        if ($barangKeluar->qr_code && Storage::disk('public')->exists($barangKeluar->qr_code)) {
            Storage::disk('public')->delete($barangKeluar->qr_code);
        }
        if ($barangKeluar->foto_penerima && Storage::disk('public')->exists($barangKeluar->foto_penerima)) {
            Storage::disk('public')->delete($barangKeluar->foto_penerima);
        }
        $barangKeluar->delete(); 

        return back()->with('success', 'Data Barang Keluar berhasil dihapus.');
    }

}
