@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-chart-bar"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="#" class="btn btn-sm btn-danger">
                <i class="fas fa-file-pdf mr-2"></i>PDF
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Tanggal</th>
                            <th>Jenis Mutasi</th>
                            <th>Jumlah</th>
                            <th>Stok Tersisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>1</td>
                            <td>Nasi Goreng Spesial</td>
                            <td>2025-04-16</td>
                            <td>Stok Masuk</td>
                            <td>30</td>
                            <td>55</td>
                        </tr>
                        <tr class="text-center">
                            <td>2</td>
                            <td>Teh Botol</td>
                            <td>2025-04-16</td>
                            <td>Stok Keluar</td>
                            <td>10</td>
                            <td>40</td>
                        </tr>
                        {{-- <!-- Nanti diisi @foreach dari controller --> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
