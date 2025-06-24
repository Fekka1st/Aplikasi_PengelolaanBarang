<?php

namespace App\Http\Controllers;

use App\Models\jenis;
use Illuminate\Http\Request;

class Kelola_JenisBarangController extends Controller
{
    //
     public function index()
    {
        $title = 'Hapus Jenis';
        $text = "Apakah Anda yakin ingin menghapus ini? ";
        confirmDelete($title, $text);
        $Jenis = jenis::all();
        return view('Kelola_Jenis.index',compact('Jenis'));
    }

    public function edit($id)
    {
        $Jenis = jenis::findOrFail($id);
        return response()->json($Jenis);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
        ]);

        jenis::create([
            'nama_jenis' => $request->nama,
        ]);
        return redirect()->back()->with('success', 'Jenis berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required',
        ]);

        $jenis = jenis::findOrFail($id);
        $jenis->update([
            'nama_jenis' => $request->nama,
        ]);
        return redirect()->back()->with('success', 'Jenis berhasil diubah');
    }

    public function destroy($id)
    {
        $jenis = jenis::findOrFail($id);
        $jenis->delete();
        return redirect()->back()->with('success', 'Jenis berhasil dihapus');
    }
}
