<?php

namespace App\Observers;

use App\Models\Stok;
use Illuminate\Support\Facades\Log;

class StokObserver
{
    /**
     * Handle the Stok "created" event.
     *
     * @param  \App\Models\Stok  $stok
     * @return void
     */
    public function created(Stok $stok)
    {
        Log::info('Stok created', [
            'id' => $stok->id,
            'barang_id' => $stok->barang_id,
            'tipe' => $stok->tipe,
            'jumlah' => $stok->jumlah,
            'tanggal' => $stok->tanggal
        ]);
    }

    /**
     * Handle the Stok "updated" event.
     *
     * @param  \App\Models\Stok  $stok
     * @return void
     */
    public function updated(Stok $stok)
    {
        Log::info('Stok updated', [
            'id' => $stok->id,
            'barang_id' => $stok->barang_id,
            'tipe' => $stok->tipe,
            'jumlah' => $stok->jumlah,
            'tanggal' => $stok->tanggal
        ]);
    }

    /**
     * Handle the Stok "deleted" event.
     *
     * @param  \App\Models\Stok  $stok
     * @return void
     */
    public function deleted(Stok $stok)
    {
        // Log the deletion for audit trail
        Log::info('Stok deleted', [
            'id' => $stok->id,
            'barang_id' => $stok->barang_id,
            'barang_nama' => $stok->barang->nama ?? 'Unknown',
            'tipe' => $stok->tipe,
            'jumlah' => $stok->jumlah,
            'tanggal' => $stok->tanggal,
            'deleted_at' => now()
        ]);

        // Clear any cached stock reports if using cache
        if (cache()->has('stock_report')) {
            cache()->forget('stock_report');
        }
    }

    /**
     * Handle the Stok "restored" event.
     *
     * @param  \App\Models\Stok  $stok
     * @return void
     */
    public function restored(Stok $stok)
    {
        Log::info('Stok restored', [
            'id' => $stok->id,
            'barang_id' => $stok->barang_id,
            'tipe' => $stok->tipe,
            'jumlah' => $stok->jumlah,
            'tanggal' => $stok->tanggal
        ]);
    }

    /**
     * Handle the Stok "force deleted" event.
     *
     * @param  \App\Models\Stok  $stok
     * @return void
     */
    public function forceDeleted(Stok $stok)
    {
        // Log the force deletion for audit trail
        Log::info('Stok force deleted', [
            'id' => $stok->id,
            'barang_id' => $stok->barang_id,
            'barang_nama' => $stok->barang->nama ?? 'Unknown',
            'tipe' => $stok->tipe,
            'jumlah' => $stok->jumlah,
            'tanggal' => $stok->tanggal,
            'force_deleted_at' => now()
        ]);

        // Clear any cached stock reports if using cache
        if (cache()->has('stock_report')) {
            cache()->forget('stock_report');
        }
    }
}
