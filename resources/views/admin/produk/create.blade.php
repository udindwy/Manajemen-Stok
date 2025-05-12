@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-fw fa-plus"></i>
            {{ $title }}
        </h1>

        <!-- Form Content -->
        <div class="card shadow mb-4">
            <div class="card-header bg-primary">
                <a href="{{ route('produk') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('produkStore') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 mb-4">
                            <div class="form-group">
                                <label>Kode Produk :</label>
                                <input type="text" id="kode_produk" class="form-control bg-light"
                                    value="PRD-{{ str_pad(App\Models\Produk::count() + 1, 4, '0', STR_PAD_LEFT) }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-xl-6 mb-4">
                            <div class="form-group">
                                <label>
                                    <span class="text-danger">*</span>Nama Produk :
                                </label>
                                <input type="text" id="nama_produk" name="nama_produk"
                                    class="form-control @error('nama_produk') is-invalid @enderror"
                                    value="{{ old('nama_produk') }}">
                                @error('nama_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 mb-4">
                            <div class="form-group">
                                <label>
                                    <span class="text-danger">*</span>Kategori :
                                </label>
                                <select id="id_kategori" name="id_kategori"
                                    class="form-control @error('id_kategori') is-invalid @enderror">
                                    <option selected disabled>--Pilih Kategori--</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->id_kategori }}"
                                            {{ old('id_kategori') == $item->id_kategori ? 'selected' : '' }}>
                                            {{ $item->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 mb-4">
                            <div class="form-group">
                                <label>
                                    <span class="text-danger">*</span>Supplier :
                                </label>
                                <select id="id_supplier" name="id_supplier"
                                    class="form-control @error('id_supplier') is-invalid @enderror">
                                    <option selected disabled>--Pilih Supplier--</option>
                                    @foreach ($supplier as $item)
                                        <option value="{{ $item->id_supplier }}"
                                            {{ old('id_supplier') == $item->id_supplier ? 'selected' : '' }}>
                                            {{ $item->nama_supplier }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 mb-4">
                            <div class="form-group">
                                <label>
                                    <span class="text-danger">*</span>Stok :
                                </label>
                                <input type="number" id="stok" name="stok"
                                    class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok') }}">
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 mb-4">
                            <div class="form-group">
                                <label>
                                    <span class="text-danger">*</span>Stok Minimal :
                                </label>
                                <input type="number" id="stok_minimal" name="stok_minimal"
                                    class="form-control @error('stok_minimal') is-invalid @enderror"
                                    value="{{ old('stok_minimal') }}">
                                @error('stok_minimal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="form-group">
                                <label>
                                    <span class="text-danger">*</span>Deskripsi :
                                </label>
                                <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
