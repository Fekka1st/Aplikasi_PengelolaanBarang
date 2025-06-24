<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Manajemen_BarangController extends Controller
{
    //
    public function index()
    {
        $title = 'Manajemen Barang';
        $text = "Apakah Anda yakin ingin menghapus ini? ";
        confirmDelete($title, $text);
        $barang = barang::with(['kategori','pengguna'])->get();
        $kategoriBarangList = kategori::all();
        return view('Manajemen_Barang.index',compact('barang','kategoriBarangList'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama_barang' => 'required',
            'kategori_barang_id' => 'required|exists:kategori_barangs,id',
            'serial_number' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:255|unique:barangs,kode_barang',
        ]);

        barang::create([
            'nama_barang' => $request->nama_barang,
            'kategori_barang_id' => $request->kategori_barang_id,
            'serial_number' => $request->serial_number,
            'kode_barang' => $request->kode_barang,
            'stok' => 0,
            'tanggal' => now(),
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = barang::with('kategori')->findOrFail($id);
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $validate = $request->validate([
            'nama_barang' => 'required',
            'kategori_barang_id' => 'required|exists:kategori_barangs,id',
            'serial_number' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:255|unique:barangs,kode_barang,' . $barang->id,
        ]);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'kategori_barang_id' => $request->kategori_barang_id,
            'serial_number' => $request->serial_number,
            'kode_barang' => $request->kode_barang,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $barang = barang::findOrFail($id);
        $barang->delete();
        return redirect()->back()->with('success', 'Barang berhasil dihapus');
    }


}
