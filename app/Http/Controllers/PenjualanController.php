<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\Stok;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualans = Penjualan::with('barang')->get();
        return view('penjualans.index', compact('penjualans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barangs = Barang::all();
        return view('penjualans.create', compact('barangs'));
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
            'jumlah' => 'required|integer|min:1',
            'harga_jual' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
        ]);
        
        // Check stock availability
        $barang = Barang::with('stoks')->findOrFail($validated['barang_id']);
        $masuk = $barang->stoks->where('tipe', 'masuk')->sum('jumlah');
        $keluar = $barang->stoks->where('tipe', 'keluar')->sum('jumlah');
        $availableStock = $masuk - $keluar;
        
        if ($availableStock < $validated['jumlah']) {
            return redirect()->back()->withErrors([
                'jumlah' => "Stok tidak mencukupi. Stok tersedia: {$availableStock}, yang diminta: {$validated['jumlah']}"
            ])->withInput();
        }
        
        $penjualan = Penjualan::create($validated + [
            'pembayaran' => $request->pembayaran
        ]);
        
        // Get barang info for feedback
        $barang = $penjualan->barang;
        
        return redirect()->route('penjualans.index')->with('success', 
            "Penjualan {$barang->nama} sebanyak {$penjualan->jumlah} berhasil ditambahkan. Stok otomatis berkurang."
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penjualan = Penjualan::with('barang')->findOrFail($id);
        return view('penjualans.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $barangs = Barang::all();
        return view('penjualans.edit', compact('penjualan', 'barangs'));
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
        $penjualan = Penjualan::findOrFail($id);
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer',
            'harga_jual' => 'required|numeric',
            'total' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);
        
        $penjualan->update($validated + [
            'pembayaran' => $request->pembayaran
        ]);
        
        // Get barang info for feedback
        $barang = $penjualan->barang;
        
        return redirect()->route('penjualans.index')->with('success', 
            "Penjualan {$barang->nama} berhasil diupdate. Stok otomatis disesuaikan."
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::with('barang')->findOrFail($id);
        
        // Store info before deletion for feedback
        $barangNama = $penjualan->barang->nama ?? 'Unknown';
        $jumlah = $penjualan->jumlah;
        
        $penjualan->delete();
        
        return redirect()->route('penjualans.index')->with('success', 
            "Penjualan {$barangNama} sebanyak {$jumlah} berhasil dihapus. Stok otomatis dikembalikan."
        );
    }

    public function laporanPenjualan()
    {
        $laporan = \App\Models\Penjualan::with('barang')
            ->selectRaw('barang_id, sum(jumlah) as total_jumlah, sum(total) as total_penjualan')
            ->groupBy('barang_id')
            ->get();
        return view('penjualans.laporan', compact('laporan'));
    }

    public function exportPdf()
    {
        $laporan = \App\Models\Penjualan::with('barang')
            ->selectRaw('barang_id, sum(jumlah) as total_jumlah, sum(total) as total_penjualan')
            ->groupBy('barang_id')
            ->get();
        
        $totalOmset = $laporan->sum('total_penjualan');
        $totalJumlah = $laporan->sum('total_jumlah');
        
        $pdf = PDF::loadView('penjualans.laporan-pdf', compact('laporan', 'totalOmset', 'totalJumlah'));
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('laporan-penjualan-' . date('Y-m-d') . '.pdf');
    }
}
