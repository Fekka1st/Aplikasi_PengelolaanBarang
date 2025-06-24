<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;

class Kelola_KategoriController extends Controller
{
    //
    public function index()
    {
        $title = 'Hapus Kategori';
        $text = "Apakah Anda yakin ingin menghapus ini? ";
        confirmDelete($title, $text);
        $kategori = kategori::all();
        return view('Kelola_Kategori.index',compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = kategori::findOrFail($id);
        return response()->json($kategori);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
        ]);

        kategori::create([
            'nama_kategori' => $request->nama,
        ]);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required',
        ]);

        $kategori = kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama,
        ]);
        return redirect()->back()->with('success', 'Kategori berhasil diubah');
    }

    public function destroy($id)
    {
        $kategori = kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}
