<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id', 'tipe', 'jumlah', 'keterangan', 'tanggal'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
