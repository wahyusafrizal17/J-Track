@extends('layouts.app')
@section('title', 'Detail Barang')
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Barang</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('barangs.index') }}">Barang</a></li>
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
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kategori</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $barang->kategori }}</p>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $barang->nama }}</p>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label class="col-sm-2 col-form-label">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $barang->deskripsi ?: '-' }}</p>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label class="col-sm-2 col-form-label">Harga Beli</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">Rp {{ number_format($barang->harga_beli,0,',','.') }}</p>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label class="col-sm-2 col-form-label">Harga Jual</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">Rp {{ number_format($barang->harga_jual,0,',','.') }}</p>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label class="col-sm-2 col-form-label">Satuan</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $barang->satuan }}</p>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label class="col-sm-2 col-form-label">Stok Minimal</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $barang->stok_minimal }}</p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="{{ route('barangs.index') }}" class="btn btn-secondary">Kembali</a>
                                            <a href="{{ route('barangs.edit', $barang->id) }}" class="btn btn-primary">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection 