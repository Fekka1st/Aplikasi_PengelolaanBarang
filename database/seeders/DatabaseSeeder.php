<?php

namespace Database\Seeders;

use App\Models\jenis;
use App\Models\kategori;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'UDIN BAAKAR',
            'email' => 'udin@mail.com',
            'password' => bcrypt('udin123'),
            'foto' => null,
            'no_telp' => '08123456789',
            'role' => '0', // 0 = Admin, 1 = HR,
        ]);

        User::factory()->create([
            'name' => 'SI PALING HR',
            'email' => 'hr@mail.com',
            'password' => bcrypt('hr123'),
            'foto' => null,
            'no_telp' => '08987654321',
            'role' => '1', // 0 = Admin, 1 = HR,
        ]);

        // Seed kategori
        $kategoriList = ['Elektronik', 'Peralatan Kantor', 'Kabel & Jaringan', 'ATK', 'Perabot'];
        foreach ($kategoriList as $kategori) {
            kategori::create([
                'nama_kategori' => $kategori,
            ]);
        }

        // Seed jenis
        $jenisList = ['Barang Baru', 'Barang Pinjam'];
        foreach ($jenisList as $jenis) {
            Jenis::create([
                'nama_jenis' => $jenis,
            ]);
        }
    }
}
