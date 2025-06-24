<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class barang_keluar extends Model
{
    //
    protected $table = 'barang_keluars';
    protected $fillable = [
        'barang_id',
        'jenis_id',
        'staff_id',
        'kode_transaksi',
        'nama_penerima',
        'foto_penerima',
        'jumlah',
        'qr_code',
    ];

    public function barang()
    {
        return $this->belongsTo(barang::class, 'barang_id');
    }

    public function jenis()
    {
        return $this->belongsTo(jenis::class, 'jenis_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }


}
