@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-plus"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-primary">
            <a href="{{ route('produk') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i>Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('produkStore') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xl-6 mb-3">
                        <label class="form-label">
                            Kode Produk :
                        </label>
                        <input type="text" class="form-control" value="PRD-{{ str_pad(App\Models\Produk::count() + 1, 4, '0', STR_PAD_LEFT) }}" readonly>
                    </div>
                    <div class="col-xl-6 mb-3">
                        <label class="form-label">
                            <span class="text-danger">*</span>
                            Nama Produk :
                        </label>
                        <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror"
                            value="{{ old('nama_produk') }}">
                        @error('nama_produk')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 mb-3">
                        <label class="form-label">
                            <span class="text-danger">*</span>
                            Kategori :
                        </label>
                        <select name="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror">
                            <option selected disabled>--Pilih Kategori--</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id_kategori }}"
                                    {{ old('id_kategori') == $item->id_kategori ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-xl-6 mb-3">
                        <label class="form-label">
                            <span class="text-danger">*</span>
                            Stok :
                        </label>
                        <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                            value="{{ old('stok') }}">
                        @error('stok')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 mb-3">
                        <label class="form-label">
                            <span class="text-danger">*</span>
                            Stok Minimal :
                        </label>
                        <input type="number" name="stok_minimal" class="form-control @error('stok_minimal') is-invalid @enderror" 
                            value="{{ old('stok_minimal') }}">
                        @error('stok_minimal')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-xl-6 mb-3">
                        <label class="form-label">
                            <span class="text-danger">*</span>
                            Deskripsi :
                        </label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
