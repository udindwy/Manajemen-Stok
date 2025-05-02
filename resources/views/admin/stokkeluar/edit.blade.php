@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-fw fa-edit"></i> {{ $title }}
        </h1>

        <div class="card shadow mb-4">
            <div class="card-header bg-warning py-3">
                <div class="d-flex align-items-center">
                    <a href="{{ route('stokkeluar') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ isset($stokKeluar) ? route('stokkeluarUpdate', $stokKeluar->id_stok_keluar) : route('stokkeluarStore') }}"
                    method="POST" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="id_produk" class="form-label">
                                <span class="text-danger">*</span>Produk:
                            </label>
                            <select id="id_produk" name="id_produk" class="form-control" readonly disabled>
                                @foreach ($produk as $p)
                                    <option value="{{ $p->id_produk }}" 
                                        {{ old('id_produk', $stokKeluar->id_produk ?? '') == $p->id_produk ? 'selected' : '' }}>
                                        {{ $p->kode_produk }} - {{ $p->nama_produk }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="id_produk" value="{{ $stokKeluar->id_produk }}">
                        </div>

                        <div class="col-xl-6 mb-3">
                            <label for="jumlah" class="form-label">
                                <span class="text-danger">*</span>Jumlah:
                            </label>
                            <input type="number" id="jumlah" name="jumlah" 
                                class="form-control @error('jumlah') is-invalid @enderror"
                                value="{{ old('jumlah', $stokKeluar->jumlah ?? '') }}">
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="tanggal_keluar" value="{{ now() }}">

                    <button type="submit" class="btn btn-sm btn-warning">
                        <i class="fas fa-save mr-2"></i>Edit
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
