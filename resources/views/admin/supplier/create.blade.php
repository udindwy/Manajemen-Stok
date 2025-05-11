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
                    <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('supplier.store') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="nama_supplier" class="form-label">
                                <span class="text-danger">*</span>Nama Supplier:
                            </label>
                            <input type="text" id="nama_supplier" name="nama_supplier"
                                class="form-control @error('nama_supplier') is-invalid @enderror"
                                value="{{ old('nama_supplier') }}">
                            @error('nama_supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="kontak" class="form-label">
                                <span class="text-danger">*</span>Kontak:
                            </label>
                            <input type="text" id="kontak" name="kontak"
                                class="form-control @error('kontak') is-invalid @enderror"
                                value="{{ old('kontak') }}">
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="lead_time" class="form-label">
                                <span class="text-danger">*</span>Lead Time (Hari):
                            </label>
                            <input type="number" id="lead_time" name="lead_time"
                                class="form-control @error('lead_time') is-invalid @enderror"
                                value="{{ old('lead_time') }}">
                            @error('lead_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="alamat" class="form-label">Alamat:</label>
                            <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                rows="3">{{ old('alamat') }}</textarea>
                            @error('alamat')
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