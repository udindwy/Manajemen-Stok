<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    protected $table = 'stok_masuk';
    protected $primaryKey = 'id_stok_masuk';
    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'jumlah',
        'id_pengguna',
        'tanggal_masuk',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
