<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;
use App\Models\Stok;
use App\Models\Penjualan;
use Carbon\Carbon;

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
        
        // Data for sales chart (last 7 days)
        $salesChartData = $this->getSalesChartData();
        
        // Data for stock movement chart
        $stockChartData = $this->getStockChartData();
        
        // Data for sales by category chart
        $categoryChartData = $this->getCategoryChartData();
        
        // Data for revenue chart (last 7 days)
        $revenueChartData = $this->getRevenueChartData();
        
        return view('welcome', compact(
            'totalBarang', 
            'omset', 
            'stokMasuk',
            'salesChartData',
            'stockChartData',
            'categoryChartData',
            'revenueChartData'
        ));
    }
    
    /**
     * Get sales chart data for last 7 days
     */
    private function getSalesChartData()
    {
        $labels = [];
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            $data[] = Penjualan::whereDate('tanggal', $date->format('Y-m-d'))->count();
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    /**
     * Get stock movement chart data
     */
    private function getStockChartData()
    {
        $masuk = Stok::where('tipe', 'masuk')->sum('jumlah');
        $keluar = Stok::where('tipe', 'keluar')->sum('jumlah');
        
        return [
            'labels' => ['Stok Masuk', 'Stok Keluar'],
            'data' => [$masuk, $keluar]
        ];
    }
    
    /**
     * Get sales by category chart data
     */
    private function getCategoryChartData()
    {
        $categories = Barang::distinct()->pluck('kategori')->toArray();
        $data = [];
        
        foreach ($categories as $category) {
            $barangIds = Barang::where('kategori', $category)->pluck('id');
            $total = Penjualan::whereIn('barang_id', $barangIds)->sum('total');
            $data[] = $total;
        }
        
        return [
            'labels' => $categories,
            'data' => $data
        ];
    }
    
    /**
     * Get revenue chart data for last 7 days
     */
    private function getRevenueChartData()
    {
        $labels = [];
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            $data[] = Penjualan::whereDate('tanggal', $date->format('Y-m-d'))->sum('total');
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}
