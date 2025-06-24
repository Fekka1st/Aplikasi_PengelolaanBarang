<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;
class kategori extends Model
{
    //

    protected $table = 'kategori_barangs';
    protected $fillable = ['nama_kategori'];

    public function barangs()
    {
        return $this->hasMany(barang::class, 'kategori_barang_id');
    }
}
