<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    //
    protected $table = 'barangs';
    protected $fillable = [
        'kategori_barang_id',
        'user_id',

        'kode_barang',
        'nama_barang',
        'serial_number',
        'stok',
    ];

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'kategori_barang_id');
    }

    public function pengguna(){
        return $this->belongsTo(User::class, 'user_id');
    }



    public function barangmasuk()
    {
        return $this->hasMany(barang_masuk::class, 'barang_id');
    }

    public function barangkeluar()
    {
        return $this->hasMany(barang_keluar::class, 'barang_id');
    }
}
