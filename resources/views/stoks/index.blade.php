@extends('layouts.app')
@section('title','Daftar Stok')
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Stok</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('stoks.index') }}">Stok</a></li>
                                <li class="breadcrumb-item active">Index</li>
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
                            <div class="card-header">
                                <h4 class="card-title">Data Stok</h4>
                                <a href="{{ route('stoks.create') }}" class="btn btn-primary btn-sm">
                                    <i data-feather='plus'></i> Tambah
                                </a>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                <div class="table-responsive">
                                    <table id="basic-datatables" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th>Barang</th>
                                                <th>Tipe</th>
                                                <th>Jumlah</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th style="width: 20%" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($stoks as $stok)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $stok->barang->nama ?? '-' }}</td>
                                                <td>{{ ucfirst($stok->tipe) }}</td>
                                                <td>{{ $stok->jumlah }}</td>
                                                <td>{{ $stok->tanggal }}</td>
                                                <td>{{ $stok->keterangan }}</td>
                                                <td class="text-center">
                                                    <div class="form-button-action">
                                                        <a href="{{ route('stoks.show', $stok->id) }}" class="btn btn-link btn-info btn-sm" title="Detail"><i data-feather='info'></i></a>
                                                        <a href="{{ route('stoks.edit', $stok->id) }}" class="btn btn-link btn-warning btn-sm" title="Edit"><i data-feather='edit'></i></a>
                                                        <form action="{{ route('stoks.destroy', $stok->id) }}" method="POST" style="display:inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link btn-danger btn-sm" onclick="return confirm('Yakin hapus?')" title="Hapus"><i data-feather='trash-2'></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
@push('scripts')
<script>
$(document).ready(function() {
    $('#basic-datatables').DataTable();
});
</script>
@endpush 