@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-edit"></i> {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-warning">
            <a href="{{ route('kategori') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('kategoriUpdate', $kategori->id_kategori) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">
                    <span class="text-danger">*</span> Nama Kategori:
                </label>
                <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror"
                    value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}">
                @error('nama_kategori')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <button type="submit" class="btn btn-sm btn-warning">
                <i class="fas fa-edit mr-2"></i> Edit
            </button>
        </form>
    </div>
    </div>
    </div>
@endsection
