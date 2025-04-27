@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-chart-bar"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="{{ route('laporan.mutasi_stok_pdf') }}" class="btn btn-sm btn-danger">
                <i class="fas fa-file-pdf mr-2"></i>PDF
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
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
                        @php $no = 1; @endphp
                        @foreach ($mutasi as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item['nama_produk'] }}</td>
                                <td>{{ $item['tanggal'] }}</td>
                                <td>{{ $item['jenis'] }}</td>
                                <td>{{ $item['jumlah'] }}</td>
                                <td>{{ $item['sisa_stok'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
