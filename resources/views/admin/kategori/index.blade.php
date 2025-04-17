@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-tags"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="#" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Kategori
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Dibuat Pada</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh data statis -->
                        <tr class="text-center">
                            <td>1</td>
                            <td>Makanan</td>
                            <td>2025-04-16</td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        {{-- <!-- Data dinamis nanti pakai @foreach --> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
