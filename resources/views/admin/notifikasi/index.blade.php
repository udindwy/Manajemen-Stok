@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-bell"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-body">
            @if ($produkMinim->count() > 0)
                <div class="alert alert-warning">
                    Beberapa produk berada di bawah batas stok minimum. Segera lakukan penambahan stok!
                </div>
            @else
                <div class="alert alert-success">
                    Semua produk memiliki stok yang cukup.
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="{{ $produkMinim->count() > 0 ? 'bg-danger' : 'bg-primary' }} text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Stok Saat Ini</th>
                            <th>Batas Minimum</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($produkMinim as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-left">{{ $item->nama_produk }}</td>
                                <td class="text-left">{{ $item->kategori->nama_kategori }}</td>
                                <td class="text-center">
                                    <span>{{ $item->stok }}</span>
                                </td>
                                <td class="text-center">{{ $item->stok_minimal }}</td>
                                <td class="text-center">
                                    <span class="badge badge-warning">Stok Minim</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
