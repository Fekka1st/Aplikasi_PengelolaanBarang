<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;
class jenis extends Model
{
    //
    protected $table = 'jenis_barangs';
    protected $fillable = ['nama_jenis'];

    public function barangkeluar()
    {
        return $this->hasMany(barang_keluar::class, 'jenis_id');
    }
}
