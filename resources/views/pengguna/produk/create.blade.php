@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-fw fa-arrow-up"></i>
            {{ $title }}
        </h1>

        <div class="card shadow mb-4">
            <div class="card-header bg-primary">
                <a href="{{ route('produk') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('stokkeluarStore') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="id_produk" class="form-label">
                                <span class="text-danger">*</span>Produk:
                            </label>
                            <select name="id_produk" id="id_produk"
                                class="form-control @error('id_produk') is-invalid @enderror">
                                <option value="">--Pilih Produk--</option>
                                @foreach ($produk as $item)
                                    <option value="{{ $item->id_produk }}"
                                        {{ old('id_produk') == $item->id_produk || (isset($selectedProduct) && $selectedProduct->id_produk == $item->id_produk) ? 'selected' : '' }}>
                                        {{ $item->kode_produk }} - {{ $item->nama_produk }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-xl-6 mb-3">
                            <label for="jumlah" class="form-label">
                                <span class="text-danger">*</span>Jumlah:
                            </label>
                            <input type="number" name="jumlah" id="jumlah"
                                class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}"
                                required min="1">
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="tanggal_keluar" value="{{ now() }}">

                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
