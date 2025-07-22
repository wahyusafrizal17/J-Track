<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;

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
            'jumlah' => 'required|integer',
            'harga_jual' => 'required|numeric',
            'total' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);
        Penjualan::create($validated + [
            'keterangan' => $request->keterangan
        ]);
        return redirect()->route('penjualans.index')->with('success', 'Data penjualan berhasil ditambahkan');
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
            'keterangan' => $request->keterangan
        ]);
        return redirect()->route('penjualans.index')->with('success', 'Data penjualan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->delete();
        return redirect()->route('penjualans.index')->with('success', 'Data penjualan berhasil dihapus');
    }

    public function laporanPenjualan()
    {
        $laporan = \App\Models\Penjualan::with('barang')
            ->selectRaw('barang_id, sum(jumlah) as total_jumlah, sum(total) as total_penjualan')
            ->groupBy('barang_id')
            ->get();
        return view('penjualans.laporan', compact('laporan'));
    }
}
