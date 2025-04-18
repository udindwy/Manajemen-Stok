<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    use HasFactory;

    protected $table = 'stok_keluar';
    protected $primaryKey = 'id_stok_keluar';

    protected $fillable = [
        'id_pengguna',
        'id_produk',
        'jumlah',
        'tanggal_keluar'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
