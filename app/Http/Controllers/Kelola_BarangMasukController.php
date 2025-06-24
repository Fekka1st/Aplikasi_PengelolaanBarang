<?php

namespace App\Http\Controllers;

use App\Helpers\MessageHelper;
use App\Models\barang;
use App\Models\barang_masuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\FuncCall;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Kelola_BarangMasukController extends Controller
{
    //
    public function index()
    {

        $title = 'Hapus Barang Masuk';
        $text = "Apakah Anda yakin ingin menghapus ini? ";
        confirmDelete($title, $text);

        $barang_masuk = barang_masuk::with('barang','staff')->get();
        $list_barang = barang::select('id','nama_barang','kode_barang','serial_number')->get();
        return view('Kelola_BarangMasuk.index',compact('barang_masuk','list_barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
        ]);
        $barang = barang::findOrFail($request->nama_barang);

        $bulan = now()->format('m');
        $tahun = now()->format('Y');
        $prefix = "BRMSK-$bulan-$tahun";

        $last = barang_masuk::where('kode_transaksi', 'LIKE', "$prefix-%")
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


        barang_masuk::create([
            'kode_transaksi' => $kodeTransaksi,
            'qr_code' => $qrPath,
            'jumlah' => $request->jumlah,
            'barang_id' => $barang->id,
            'staff_id' => Auth::id(),
        ]);

        $barang->increment('stok', $request->jumlah);

        $hrUsers = User::where('role', 1)->get();
        $kodeBarang = $barang->kode_barang ?? '-';
        $namaBarang = $barang->nama_barang ?? '-';
        $jumlah = $request->jumlah;
        foreach ($hrUsers as $hr) {
            $message = "Halo {$hr->name},\n\nTelah dilakukan *penambahan barang masuk* dengan detail berikut:\n\n" .
                    "- Kode Transaksi: $kodeTransaksi\n" .
                    "- Kode Barang: $kodeBarang\n" .
                    "- Nama Barang: $namaBarang\n" .
                    "- Jumlah: $jumlah\n\n" .
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

        return back()->with('success', 'Data Barang Masuk berhasil disimpan dan notifikasi berhasil dikirim..');
    }

    public function edit($edit){
        $barang = barang_masuk::select('id','barang_id','jumlah')->find($edit);
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $barangMasuk = barang_masuk::findOrFail($id);
        $barangLama = barang::findOrFail($barangMasuk->barang_id);
        $jumlahLama = $barangMasuk->jumlah;

        $barangLama->decrement('stok', $jumlahLama);

        $barangBaru = barang::findOrFail($request->nama_barang);
        $barangMasuk->update([
            'barang_id' => $barangBaru->id,
            'jumlah' => $request->jumlah,
        ]);
        $barangBaru->increment('stok', $request->jumlah);

        // Kirim notifikasi ke HR
        $hrUsers = User::where('role', 1)->get();
        $errors = [];

        foreach ($hrUsers as $hr) {
            $message = "Halo {$hr->name},\n\nData barang masuk telah *diperbarui* dengan detail:\n\n" .
                    "- Kode Transaksi: {$barangMasuk->kode_transaksi}\n" .
                    "- Kode Barang: {$barangBaru->kode_barang}\n" .
                    "- Nama Barang: {$barangBaru->nama_barang}\n" .
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

        return back()->with('success', 'Data Barang Masuk berhasil diperbarui dan notifikasi berhasil dikirim..');
    }

    public function destroy($id)
    {
        $barangMasuk = barang_masuk::findOrFail($id);

        $barang = barang::findOrFail($barangMasuk->barang_id);
        $barang->decrement('stok', $barangMasuk->jumlah);

        if ($barangMasuk->qr_code && Storage::disk('public')->exists($barangMasuk->qr_code)) {
            Storage::disk('public')->delete($barangMasuk->qr_code);
        }

        $barangMasuk->delete();

        return back()->with('success', 'Data Barang Masuk berhasil dihapus.');
    }


}
