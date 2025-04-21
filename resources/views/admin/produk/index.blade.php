@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-users"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="{{ route('produkCreate') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Produk
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
                            <th>Stok</th>
                            <th>Stok Minimal</th>
                            <th>Deskripsi</th>
                            <th>Dibuat pada</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($produk as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->kategori->nama_kategori }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>{{ $item->stok_minimal }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>{{ $item->dibuat_pada }}</td>
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
