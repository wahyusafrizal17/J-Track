@extends('layouts.app')
@section('title', 'Detail Barang')
@section('content')
<div class="container mt-3">
    <h1>Detail Barang</h1>
    <table class="table table-bordered">
        <tr><th>Kode</th><td>{{ $barang->kode }}</td></tr>
        <tr><th>Nama</th><td>{{ $barang->nama }}</td></tr>
        <tr><th>Deskripsi</th><td>{{ $barang->deskripsi }}</td></tr>
        <tr><th>Harga</th><td>{{ number_format($barang->harga,0,',','.') }}</td></tr>
        <tr><th>Satuan</th><td>{{ $barang->satuan }}</td></tr>
        <tr><th>Stok Minimal</th><td>{{ $barang->stok_minimal }}</td></tr>
    </table>
    <a href="{{ route('barangs.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection 