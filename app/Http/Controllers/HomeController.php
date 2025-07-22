<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;
use App\Models\Stok;

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
        $totalPetugas = User::count();
        $totalBarang = Barang::count();
        $totalStok = Stok::sum('jumlah');
        return view('welcome', compact('totalPetugas', 'totalBarang', 'totalStok'));
    }
}
