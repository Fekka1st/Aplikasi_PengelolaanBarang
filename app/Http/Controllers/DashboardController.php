<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\barang_keluar;
use App\Models\barang_masuk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $barangMasuk = barang_masuk::with(['barang.kategori', 'staff'])
            ->select('id', 'barang_id', 'jumlah', 'staff_id', 'created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'kode_barang' => $item->barang->kode_barang,
                    'nama_barang' => $item->barang->nama_barang,
                    'serial_number' => $item->barang->serial_number,
                    'kategori' => $item->barang->kategori->nama_kategori ?? '-',
                    'jumlah' => $item->jumlah,
                    'tipe' => 'Barang Masuk',
                    'staff' => $item->staff->name,
                    'waktu' => $item->created_at->format('d-m-Y H:i')
                ];
            });

        $barangKeluar = barang_keluar::with(['barang.kategori', 'staff'])
            ->select('id', 'barang_id', 'jumlah', 'staff_id', 'created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'kode_barang' => $item->barang->kode_barang,
                    'nama_barang' => $item->barang->nama_barang,
                    'serial_number' => $item->barang->serial_number,
                    'kategori' => $item->barang->kategori->nama_kategori ?? '-',
                    'jumlah' => $item->jumlah,
                    'tipe' => 'Barang Keluar',
                    'staff' => $item->staff->name,
                    'waktu' => $item->created_at->format('d-m-Y H:i')
                ];
            });

        $totalStokBarang = barang::sum('stok');
        $totalBarangMasuk = barang_masuk::sum('jumlah');
        $totalBarangKeluar = barang_keluar::sum('jumlah');

        $transaksi = $barangMasuk->concat($barangKeluar)->sortByDesc('waktu');
        return view('dashboard',compact('transaksi','totalStokBarang','totalBarangMasuk','totalBarangKeluar'));
    }

    public function cek_barang($kode_transaksi)
    {
        $data = barang_masuk::with(['barang', 'staff'])
            ->where('kode_transaksi', $kode_transaksi)
            ->first();
        $tipe = 'Barang Masuk';
        if (!$data) {
            $data = barang_keluar::with(['barang', 'staff'])
                ->where('kode_transaksi', $kode_transaksi)
                ->first();
            $tipe = 'Barang Keluar';
        }
        if (!$data) {
            return view('cek_barang')->with('not_found', true);
        }
        return view('cek_barang', compact('data', 'tipe'));
    }
}
