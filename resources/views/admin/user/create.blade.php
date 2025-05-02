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
                    <a href="{{ route('user') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('userStore') }}" method="post" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="nama" class="form-label">
                                <span class="text-danger">*</span>Nama:
                            </label>
                            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="email" class="form-label">
                                <span class="text-danger">*</span>Email:
                            </label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 mb-3">
                            <label for="peran" class="form-label">
                                <span class="text-danger">*</span>Role:
                            </label>
                            <select id="peran" name="peran" class="form-control @error('peran') is-invalid @enderror">
                                <option selected disabled>--Pilih Role--</option>
                                <option value="admin">Admin</option>
                                <option value="pengguna">Pengguna</option>
                            </select>
                            @error('peran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="password" class="form-label">
                                <span class="text-danger">*</span>Password:
                            </label>
                            <input type="password" id="password" name="password" 
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-xl-6 mb-3">
                            <label for="password_confirmation" class="form-label">
                                <span class="text-danger">*</span>Password Konfirmasi:
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
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
