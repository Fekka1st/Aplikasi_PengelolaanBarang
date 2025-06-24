<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class barang_masuk extends Model
{
    //
    protected $table = 'barang_masuks';
    protected $fillable = [
        'barang_id',
        'staff_id',
        'jumlah',
        'qr_code',
        'kode_transaksi',
    ];



    public function barang()
    {
        return $this->belongsTo(barang::class, 'barang_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }


}
