<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\barang_keluar;
use App\Models\barang_masuk;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
     public function index(Request $request)
    {
        $jenis = $request->jenis;
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $data = [];
        if ($jenis && $tgl_awal && $tgl_akhir) {
            if ($jenis == 'Barang-Masuk') {
                $data = barang_masuk::with('barang','staff')->whereBetween('created_at', [$tgl_awal, $tgl_akhir])
                    ->orderBy('created_at', 'desc')
                    ->get();
            } elseif ($jenis == 'Barang-Keluar') {
                $data = barang_keluar::with('barang','staff','jenis')->whereBetween('created_at', [$tgl_awal, $tgl_akhir])
                    ->orderBy('created_at', 'desc')
                    ->get();
            } elseif ($jenis == 'Total-Stok') {
                $data = Barang::with(['kategori', 'pengguna'])->get();
            }
        }
        return view('Laporan.index', compact('jenis', 'tgl_awal', 'tgl_akhir', 'data'));
    }
}
