@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-arrow-up"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="{{ route('stokkeluarCreate') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Stok Keluar
            </a>
        </div>
        <div class="card-body">
            <h1>HALAMAN PENGGUNA</h1>
        </div>
    </div>
@endsection
