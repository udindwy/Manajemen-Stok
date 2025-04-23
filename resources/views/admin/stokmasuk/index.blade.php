@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-arrow-down"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="{{ route('stokmasukCreate') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Stok Masuk
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
                            <th>Jumlah Masuk</th>
                            <th>Tanggal Masuk</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stokMasuk as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->produk->nama_produk }}</td>
                                <td>{{ $item->produk->kategori->nama_kategori }}</td>
                                <td class="text-center">{{ $item->jumlah }}</td>
                                <td class="text-center">{{ $item->tanggal_masuk }}</td>
                                <td class="text-center">
                                    <a href="{{ route('stokmasukEdit', $item->id_stok_masuk) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#modalHapusStokMasuk{{ $item->id_stok_masuk }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @include('admin.stokmasuk.modal')
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
