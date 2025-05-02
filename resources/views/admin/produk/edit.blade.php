@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-fw fa-edit"></i>
            {{ $title }}
        </h1>

        <!-- Form Content -->
        <div class="card shadow mb-4">
            <div class="card-header bg-warning">
                <a href="{{ route('produk') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('produkUpdate', $produk->id_produk) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="kode_produk" class="form-label">Kode Produk :</label>
                            <input type="text" id="kode_produk" class="form-control" value="{{ $produk->kode_produk }}" readonly>
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="nama_produk" class="form-label">
                                <span class="text-danger">*</span>Nama Produk :
                            </label>
                            <input type="text" id="nama_produk" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk', $produk->nama_produk) }}">
                            @error('nama_produk')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="id_kategori" class="form-label">
                                <span class="text-danger">*</span>Kategori :
                            </label>
                            <select id="id_kategori" name="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror">
                                <option selected disabled>--Pilih Kategori--</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id_kategori }}" {{ old('id_kategori', $produk->id_kategori) == $item->id_kategori ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="stok" class="form-label">
                                <span class="text-danger">*</span>Stok :
                            </label>
                            <input type="number" id="stok" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $produk->stok) }}">
                            @error('stok')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="stok_minimal" class="form-label">
                                <span class="text-danger">*</span>Stok Minimal :
                            </label>
                            <input type="number" id="stok_minimal" name="stok_minimal" class="form-control @error('stok_minimal') is-invalid @enderror" value="{{ old('stok_minimal', $produk->stok_minimal) }}">
                            @error('stok_minimal')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="deskripsi" class="form-label">
                                <span class="text-danger">*</span>Deskripsi :
                            </label>
                            <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
