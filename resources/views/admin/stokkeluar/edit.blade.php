@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-edit"></i> {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-warning">
            <a href="{{ route('stokkeluar') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form
            action="{{ isset($stokKeluar) ? route('stokkeluarEdit', $stokKeluar->id_stok_keluar) : route('stokkeluarStore') }}"
            method="POST">
            @csrf
            @if (isset($stokKeluar))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">
                    <span class="text-danger">*</span> Produk:
                </label>
                <select name="id_produk" class="form-control @error('id_produk') is-invalid @enderror">
                    <option disabled {{ old('id_produk', $stokKeluar->id_produk ?? '') == '' ? 'selected' : '' }}>-- Pilih
                        Produk --</option>
                    @foreach ($produk as $p)
                        <option value="{{ $p->id_produk }}"
                            {{ old('id_produk', $stokKeluar->id_produk ?? '') == $p->id_produk ? 'selected' : '' }}>
                            {{ $p->nama_produk }}
                        </option>
                    @endforeach
                </select>
                @error('id_produk')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <span class="text-danger">*</span> Jumlah:
                </label>
                <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                    value="{{ old('jumlah', $stokKeluar->jumlah ?? '') }}">
                @error('jumlah')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <span class="text-danger">*</span> Tanggal Keluar:
                </label>
                <input type="datetime-local" name="tanggal_keluar"
                    class="form-control @error('tanggal_keluar') is-invalid @enderror"
                    value="{{ old('tanggal_keluar', isset($stokKeluar) ? \Carbon\Carbon::parse($stokKeluar->tanggal_keluar)->format('Y-m-d\TH:i') : '') }}">
                @error('tanggal_keluar')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-sm btn-warning">
                <i class="fas fa-save mr-2"></i> Edit
            </button>
        </form>
    </div>
    </div>
    </div>
@endsection
