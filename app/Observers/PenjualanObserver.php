<?php

namespace App\Observers;

use App\Models\Penjualan;
use App\Models\Stok;
use Illuminate\Support\Facades\Log;

class PenjualanObserver
{
    /**
     * Handle the Penjualan "created" event.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return void
     */
    public function created(Penjualan $penjualan)
    {
        // Automatically reduce stock when a sale is created
        $this->reduceStock($penjualan);
        
        Log::info('Penjualan created and stock reduced', [
            'penjualan_id' => $penjualan->id,
            'barang_id' => $penjualan->barang_id,
            'barang_nama' => $penjualan->barang->nama ?? 'Unknown',
            'jumlah' => $penjualan->jumlah,
            'total' => $penjualan->total,
            'tanggal' => $penjualan->tanggal
        ]);
    }

    /**
     * Handle the Penjualan "updated" event.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return void
     */
    public function updated(Penjualan $penjualan)
    {
        // If quantity changed, adjust stock accordingly
        if ($penjualan->wasChanged('jumlah')) {
            $oldQuantity = $penjualan->getOriginal('jumlah');
            $newQuantity = $penjualan->jumlah;
            $difference = $newQuantity - $oldQuantity;
            
            if ($difference != 0) {
                $this->adjustStock($penjualan, $difference);
            }
        }
        
        Log::info('Penjualan updated', [
            'penjualan_id' => $penjualan->id,
            'barang_id' => $penjualan->barang_id,
            'barang_nama' => $penjualan->barang->nama ?? 'Unknown',
            'jumlah' => $penjualan->jumlah,
            'total' => $penjualan->total,
            'tanggal' => $penjualan->tanggal
        ]);
    }

    /**
     * Handle the Penjualan "deleted" event.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return void
     */
    public function deleted(Penjualan $penjualan)
    {
        // Restore stock when sale is deleted
        $this->restoreStock($penjualan);
        
        Log::info('Penjualan deleted and stock restored', [
            'penjualan_id' => $penjualan->id,
            'barang_id' => $penjualan->barang_id,
            'barang_nama' => $penjualan->barang->nama ?? 'Unknown',
            'jumlah' => $penjualan->jumlah,
            'total' => $penjualan->total,
            'tanggal' => $penjualan->tanggal
        ]);
    }

    /**
     * Handle the Penjualan "restored" event.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return void
     */
    public function restored(Penjualan $penjualan)
    {
        //
    }

    /**
     * Handle the Penjualan "force deleted" event.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return void
     */
    public function forceDeleted(Penjualan $penjualan)
    {
        //
    }

    /**
     * Reduce stock when sale is created
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return void
     */
    private function reduceStock(Penjualan $penjualan)
    {
        try {
            // Create stock out record
            Stok::create([
                'barang_id' => $penjualan->barang_id,
                'tipe' => 'keluar',
                'jumlah' => $penjualan->jumlah,
                'tanggal' => $penjualan->tanggal,
                'kadaluwarsa' => null,
                'keterangan' => 'Penjualan otomatis - ID: ' . $penjualan->id
            ]);
            
            // Clear stock report cache
            $this->clearStockReportCache();
            
        } catch (\Exception $e) {
            Log::error('Failed to reduce stock for sale', [
                'penjualan_id' => $penjualan->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Adjust stock when sale quantity is changed
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @param  int  $difference
     * @return void
     */
    private function adjustStock(Penjualan $penjualan, $difference)
    {
        try {
            if ($difference > 0) {
                // Quantity increased, reduce more stock
                Stok::create([
                    'barang_id' => $penjualan->barang_id,
                    'tipe' => 'keluar',
                    'jumlah' => $difference,
                    'tanggal' => $penjualan->tanggal,
                    'kadaluwarsa' => null,
                    'keterangan' => 'Penyesuaian penjualan - ID: ' . $penjualan->id
                ]);
            } else {
                // Quantity decreased, restore some stock
                Stok::create([
                    'barang_id' => $penjualan->barang_id,
                    'tipe' => 'masuk',
                    'jumlah' => abs($difference),
                    'tanggal' => $penjualan->tanggal,
                    'kadaluwarsa' => null,
                    'keterangan' => 'Pengembalian penjualan - ID: ' . $penjualan->id
                ]);
            }
            
            // Clear stock report cache
            $this->clearStockReportCache();
            
        } catch (\Exception $e) {
            Log::error('Failed to adjust stock for sale', [
                'penjualan_id' => $penjualan->id,
                'difference' => $difference,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Restore stock when sale is deleted
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return void
     */
    private function restoreStock(Penjualan $penjualan)
    {
        try {
            // Create stock in record to restore
            Stok::create([
                'barang_id' => $penjualan->barang_id,
                'tipe' => 'masuk',
                'jumlah' => $penjualan->jumlah,
                'tanggal' => $penjualan->tanggal,
                'kadaluwarsa' => null,
                'keterangan' => 'Pembatalan penjualan - ID: ' . $penjualan->id
            ]);
            
            // Clear stock report cache
            $this->clearStockReportCache();
            
        } catch (\Exception $e) {
            Log::error('Failed to restore stock for deleted sale', [
                'penjualan_id' => $penjualan->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Clear stock report cache
     *
     * @return void
     */
    private function clearStockReportCache()
    {
        if (cache()->has('stock_report')) {
            cache()->forget('stock_report');
        }
    }
}
