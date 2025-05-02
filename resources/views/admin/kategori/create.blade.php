@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-fw fa-plus"></i> {{ $title }}
        </h1>

        <!-- Form Content -->
        <div class="card shadow mb-4">
            <div class="card-header bg-primary py-3">
                <div class="d-flex align-items-center">
                    <a href="{{ route('kategori') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('kategoriStore') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="nama_kategori" class="form-label">
                                <span class="text-danger">*</span>Nama Kategori:
                            </label>
                            <input type="text" id="nama_kategori" name="nama_kategori"
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori') }}">
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
