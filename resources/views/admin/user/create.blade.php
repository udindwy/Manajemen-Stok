@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-plus"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header">
            <div>
                <a href="{{ route('user') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('userStore') }}" method="post">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-xl-6 mb-2">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                Nama :
                            </label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}">
                            @error('nama')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                Email :
                            </label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}">
                            @error('email')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-xl-12 mb-1">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                Role :
                            </label>
                            <select name="peran" class="form-control @error('peran') is-invalid @enderror">
                                <option selected disabled>--Pilih Role--</option>
                                <option value="admin">Admin</option>
                                <option value="pengguna">Pengguna</option>
                            </select>
                            @error('peran')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-xl-6 mb-2">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                Password :
                            </label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label">
                                <span class="text-danger">*</span>
                                Password Konfirmasi :
                            </label>
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
