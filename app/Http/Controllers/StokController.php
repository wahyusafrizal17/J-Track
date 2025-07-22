<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Barang;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stoks = Stok::with('barang')->get();
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
        ]);
        Stok::create($validated + [
            'keterangan' => $request->keterangan
        ]);
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
        ]);
        $stok->update($validated + [
            'keterangan' => $request->keterangan
        ]);
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
        $stok = Stok::findOrFail($id);
        $stok->delete();
        return redirect()->route('stoks.index')->with('success', 'Data stok berhasil dihapus');
    }

    public function laporanStok()
    {
        $laporan = [];
        $barangs = \App\Models\Barang::with('stoks')->get();
        foreach ($barangs as $barang) {
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
        return view('stoks.laporan', compact('laporan'));
    }
}
