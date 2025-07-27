<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;
use App\Models\Stok;
use App\Models\Penjualan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalBarang = Barang::count();
        $omset = Penjualan::sum('total');
        $stokMasuk = Stok::where('tipe', 'masuk')->sum('jumlah');
        return view('welcome', compact('totalBarang', 'omset', 'stokMasuk'));
    }
}
