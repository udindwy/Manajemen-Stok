@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-fw fa-box"></i> {{ $title }}
        </h1>

        <!-- Product Detail -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <div class="d-flex align-items-center">
                    <a href="{{ route('produk') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- QR Code Section -->
                    <div class="col-md-4 text-center mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <h5 class="font-weight-bold text-primary mb-3">QR Code</h5>
                                {!! $produk->qr_code !!}
                                <div class="mt-3">
                                    <span class="badge badge-primary">{{ $produk->kode_produk }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Section -->
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="bg-light" widtd="30%">Kode Produk</td>
                                        <td>{{ $produk->kode_produk }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light">Nama Produk</td>
                                        <td>{{ $produk->nama_produk }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light">Kategori</td>
                                        <td>{{ $produk->kategori->nama_kategori }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light">Supplier</td>
                                        <td>{{ $produk->supplier->nama_supplier ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light">Stok Saat Ini</td>
                                        <td>
                                            <span>{{ $produk->stok }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light">Stok Minimal</td>
                                        <td>
                                            <span>{{ $produk->stok_minimal }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light">Total Stok Masuk</td>
                                        <td>
                                            <span>{{ $totalStokMasuk }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light">Total Stok Keluar</td>
                                        <td>
                                            <span>{{ $totalStokKeluar }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light">Deskripsi</td>
                                        <td>{{ $produk->deskripsi ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light">Dibuat Pada</td>
                                        <td>
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            {{ \Carbon\Carbon::parse($produk->dibuat_pada)->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
