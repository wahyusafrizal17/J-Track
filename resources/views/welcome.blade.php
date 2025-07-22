@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Dashboard</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="card-title">Total Petugas</h4>
                            <h2>{{ $totalPetugas }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="card-title">Total Barang</h4>
                            <h2>{{ $totalBarang }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="card-title">Total Stok</h4>
                            <h2>{{ $totalStok }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection