<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stoks = Stok::with('barang')->where('tipe', 'masuk')->get();
        return view('stoks.index', compact('stoks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barangs = Barang::all();
        return view('stoks.create', compact('barangs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tipe' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer',
            'tanggal' => 'required|date',
            'kadaluwarsa' => 'date',
        ]);
        Stok::create($validated);
        
        // Clear stock report cache when new stock is added
        $this->clearStockReportCache();
        
        return redirect()->route('stoks.index')->with('success', 'Data stok berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stok = Stok::with('barang')->findOrFail($id);
        return view('stoks.show', compact('stok'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stok = Stok::findOrFail($id);
        $barangs = Barang::all();
        return view('stoks.edit', compact('stok', 'barangs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $stok = Stok::findOrFail($id);
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tipe' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer',
            'tanggal' => 'required|date',
            'kadaluwarsa' => 'date',
        ]);
        $stok->update($validated + [
            'keterangan' => $request->keterangan
        ]);
        
        // Clear stock report cache when stock is updated
        $this->clearStockReportCache();
        
        return redirect()->route('stoks.index')->with('success', 'Data stok berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $stok = Stok::with('barang')->findOrFail($id);
            
            // Validate if deletion would cause negative stock
            if (!$this->validateStockDeletion($stok)) {
                return redirect()->route('stoks.index')->with('error', 
                    'Tidak dapat menghapus data stok ini karena akan menyebabkan saldo stok negatif.'
                );
            }
            
            // Store information before deletion for feedback
            $barangNama = $stok->barang->nama ?? 'Unknown';
            $tipe = $stok->tipe;
            $jumlah = $stok->jumlah;
            
            // Delete the stok record
            $stok->delete();
            
            // Clear stock report cache when stock is deleted
            $this->clearStockReportCache();
            
            return redirect()->route('stoks.index')->with('success', 
                "Data stok {$tipe} untuk barang '{$barangNama}' sebanyak {$jumlah} berhasil dihapus. Laporan stok akan otomatis terupdate."
            );
        } catch (\Exception $e) {
            return redirect()->route('stoks.index')->with('error', 
                'Gagal menghapus data stok. Silakan coba lagi.'
            );
        }
    }

    public function laporanStok()
    {
        // Use cache for better performance, cache for 5 minutes
        $laporan = cache()->remember('stock_report', 300, function () {
            $laporan = [];
            $barangs = \App\Models\Barang::with('stoks')->get();
            
            foreach ($barangs as $barang) {
                // Calculate stock movements
                $masuk = $barang->stoks->where('tipe', 'masuk')->sum('jumlah');
                $keluar = $barang->stoks->where('tipe', 'keluar')->sum('jumlah');
                $saldo = $masuk - $keluar;
                
                $laporan[] = [
                    'barang' => $barang,
                    'masuk' => $masuk,
                    'keluar' => $keluar,
                    'saldo' => $saldo
                ];
            }
            
            return $laporan;
        });
        
        return view('stoks.laporan', compact('laporan'));
    }

    public function exportPdf()
    {
        $laporan = cache()->remember('stock_report', 300, function () {
            $laporan = [];
            $barangs = \App\Models\Barang::with('stoks')->get();
            
            foreach ($barangs as $barang) {
                // Calculate stock movements
                $masuk = $barang->stoks->where('tipe', 'masuk')->sum('jumlah');
                $keluar = $barang->stoks->where('tipe', 'keluar')->sum('jumlah');
                $saldo = $masuk - $keluar;
                
                $laporan[] = [
                    'barang' => $barang,
                    'masuk' => $masuk,
                    'keluar' => $keluar,
                    'saldo' => $saldo
                ];
            }
            
            return $laporan;
        });
        
        $totalMasuk = collect($laporan)->sum('masuk');
        $totalKeluar = collect($laporan)->sum('keluar');
        $totalSaldo = collect($laporan)->sum('saldo');
        
        $pdf = PDF::loadView('stoks.laporan-pdf', compact('laporan', 'totalMasuk', 'totalKeluar', 'totalSaldo'));
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('laporan-stok-' . date('Y-m-d') . '.pdf');
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

    /**
     * Validate if stock deletion would cause negative balance
     *
     * @param  \App\Models\Stok  $stok
     * @return bool
     */
    private function validateStockDeletion($stok)
    {
        // Get current stock balance for this item
        $barang = $stok->barang;
        $masuk = $barang->stoks->where('tipe', 'masuk')->sum('jumlah');
        $keluar = $barang->stoks->where('tipe', 'keluar')->sum('jumlah');
        $currentBalance = $masuk - $keluar;
        
        // If this is a 'masuk' record, check if removing it would cause negative balance
        if ($stok->tipe === 'masuk') {
            $newBalance = $currentBalance - $stok->jumlah;
            return $newBalance >= 0;
        }
        
        // If this is a 'keluar' record, it's generally safe to delete
        return true;
    }
}
