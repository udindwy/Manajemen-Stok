<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'pesan',
        'status_dibaca',
        'dibuat_pada'
    ];

    protected $casts = [
        'status_dibaca' => 'boolean',
        'dibuat_pada' => 'datetime'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
