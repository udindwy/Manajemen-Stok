<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $timestamps = false;

    protected $fillable = [
        'nama_produk',
        'kode_produk',
        'id_kategori',
        'stok',
        'stok_minimal',
        'deskripsi',
        'dibuat_pada',
        'qr_code',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function scopeStokMinim($query)
    {
        return $query->whereRaw('stok <= stok_minimal');
    }

    public function getStokStatus()
    {
        if ($this->stok <= $this->stok_minimal) {
            return 'danger';
        }
        return 'success';
    }
}
