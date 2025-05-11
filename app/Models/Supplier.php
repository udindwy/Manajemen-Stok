<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    public $timestamps = false;

    protected $fillable = [
        'nama_supplier',
        'kontak',
        'alamat',
        'lead_time',
        'dibuat_pada'
    ];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_supplier');
    }
}