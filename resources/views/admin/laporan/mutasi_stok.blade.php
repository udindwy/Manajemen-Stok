@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-chart-bar"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="{{ route(Auth::user()->peran == 'admin' ? 'laporan.mutasi_stok_pdf' : 'laporan.mutasi_stok_pdf') }}"
                class="btn btn-sm btn-danger">
                <i class="fas fa-file-pdf mr-2"></i>PDF
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Tanggal</th>
                            @if (Auth::user()->peran == 'admin')
                                <th>Jenis Mutasi</th>
                                <th>Nama Pengguna</th>
                            @endif
                            <th>Jumlah</th>
                            @if (Auth::user()->peran == 'admin')
                                <th>Stok Tersisa</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($mutasi as $item)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $item['kode_produk'] }}</td>
                                <td class="text-left">{{ $item['nama_produk'] }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y H:i') }}</td>
                                @if (Auth::user()->peran == 'admin')
                                    <td class="text-center">{{ $item['jenis'] }}</td>
                                    <td class="text-left">{{ $item['nama_pengguna'] }}</td>
                                @endif
                                <td class="text-center">{{ $item['jumlah'] }}</td>
                                @if (Auth::user()->peran == 'admin')
                                    <td class="text-center">{{ $item['sisa_stok'] }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
