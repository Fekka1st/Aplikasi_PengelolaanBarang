<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Kelola_PenggunaController extends Controller
{
    //

    public function index()
    {
        $title = 'Hapus Pengguna';
        $text = "Apakah Anda yakin ingin menghapus ini? ";
        confirmDelete($title, $text);
        $pengguna = User::all();
        return view('Kelola_Pengguna.index',compact('pengguna'));
    }

    public function edit($id)
    {
        $pengguna = User::findOrFail($id);
        return response()->json($pengguna);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
            'no_telp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('profile_photos', 'public');
        }

        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'no_telp' => $request->no_telp,
            'foto' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:6',
            'role' => 'required',
            'no_telp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);
        $pengguna = User::findOrFail($id);
        $fotoPath = $pengguna->foto;
        $password = $pengguna->password;

        if($request->password){
            $password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
             if ($pengguna->foto && Storage::exists($pengguna->foto)) {
                Storage::disk('public')->delete($pengguna->foto);
            }
            $fotoPath = $request->file('foto')->store('profile_photos', 'public');
        }

        $pengguna->update([
            'name' => $request->nama,
            'email' => $request->email,
            'password' =>  $password,
            'role' => $request->role,
            'no_telp' => $request->no_telp,
            'foto' => $fotoPath,
        ]);
        return redirect()->back()->with('success', 'Pengguna berhasil diubah');
    }

    public function destroy($id)
    {
        $pengguna = User::findOrFail($id);

        if ($pengguna->foto && Storage::disk('public')->exists($pengguna->foto)) {
            Storage::disk('public')->delete($pengguna->foto);
        }

        $pengguna->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
