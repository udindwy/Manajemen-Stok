@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-edit"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-warning">
            <a href="{{ route('produk') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i>Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('produkUpdate', $produk->id_produk) }}" method="post">
            @csrf
            <div class="row mb-2">
                <div class="col-xl-6 mb-2">
                    <label class="form-label">
                        <span class="text-danger">*</span>
                        Nama Produk :
                    </label>
                    <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror"
                        value="{{ old('nama_produk', $produk->nama_produk ?? '') }}">
                    @error('nama_produk')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="col-xl-6">
                    <label class="form-label">
                        <span class="text-danger">*</span>
                        Kategori :
                    </label>
                    <select name="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror">
                        <option selected disabled>--Pilih Kategori--</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id_kategori }}"
                                {{ old('id_kategori', $produk->id_kategori ?? '') == $item->id_kategori ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-xl-6 mb-2">
                    <label class="form-label">
                        <span class="text-danger">*</span>
                        Stok :
                    </label>
                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                        value="{{ old('stok', $produk->stok ?? '') }}">
                    @error('stok')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="col-xl-6">
                    <label class="form-label">
                        <span class="text-danger">*</span>
                        Stok Minimal :
                    </label>
                    <input type="number" name="stok_minimal"
                        class="form-control @error('stok_minimal') is-invalid @enderror"
                        value="{{ old('stok_minimal', $produk->stok_minimal ?? '') }}">
                    @error('stok_minimal')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-xl-12 mb-2">
                    <label class="form-label">
                        <span class="text-danger">*</span>
                        Deskripsi :
                    </label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit mr-2"></i> Edit
                </button>
            </div>
        </form>
    </div>

    </div>
    </div>
@endsection
