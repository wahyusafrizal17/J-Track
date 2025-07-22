@extends('layouts.app')
@section('title', 'Detail Penjualan')
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Penjualan</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('penjualans.index') }}">Penjualan</a></li>
                                <li class="breadcrumb-item active">Detail</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="dashboard-analytics">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Detail Penjualan</h4>
                                <table class="table table-bordered">
                                    <tr><th>Barang</th><td>{{ $penjualan->barang->nama ?? '-' }}</td></tr>
                                    <tr><th>Jumlah</th><td>{{ $penjualan->jumlah }}</td></tr>
                                    <tr><th>Harga Jual</th><td>{{ number_format($penjualan->harga_jual,0,',','.') }}</td></tr>
                                    <tr><th>Total</th><td>{{ number_format($penjualan->total,0,',','.') }}</td></tr>
                                    <tr><th>Tanggal</th><td>{{ $penjualan->tanggal }}</td></tr>
                                    <tr><th>Keterangan</th><td>{{ $penjualan->keterangan }}</td></tr>
                                </table>
                                <a href="{{ route('penjualans.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection 