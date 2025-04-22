@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-plus"></i> {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-primary">
            <a href="{{ route('stokmasuk') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('stokmasukStore') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">
                    <span class="text-danger">*</span> Produk:
                </label>
                <select name="id_produk" class="form-control @error('id_produk') is-invalid @enderror">
                    <option selected disabled>-- Pilih Produk --</option>
                    @foreach ($produk as $p)
                        <option value="{{ $p->id_produk }}" {{ old('id_produk') == $p->id_produk ? 'selected' : '' }}>
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
                    value="{{ old('jumlah') }}">
                @error('jumlah')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <span class="text-danger">*</span> Tanggal Masuk:
                </label>
                <input type="datetime-local" name="tanggal_masuk"
                    class="form-control @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk') }}">
                @error('tanggal_masuk')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-sm btn-primary">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </form>
    </div>
    </div>
    </div>
@endsection
