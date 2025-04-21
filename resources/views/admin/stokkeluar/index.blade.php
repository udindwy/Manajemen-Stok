@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-arrow-up"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="{{ route('stokkeluarCreate') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Stok Keluar
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Jumlah Keluar</th>
                            <th>Tanggal Keluar</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stokKeluar as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->produk->nama_produk }}</td>
                                <td>{{ $item->produk->kategori->nama_kategori }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('Y-m-d H:i:s') }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
