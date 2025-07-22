<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode', 'nama', 'deskripsi', 'harga', 'satuan', 'stok_minimal'
    ];

    public function stoks()
    {
        return $this->hasMany(Stok::class);
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}
