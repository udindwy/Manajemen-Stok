@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-chart-bar"></i>
        Laporan Mutasi Stok
    </h1>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('laporan.mutasi_stok') }}" method="GET" class="row align-items-end">
                <div class="col-md-3 mb-3">
                    <select name="kategori" class="form-control" title="Pilih Kategori">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}"
                                {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-3 mb-3 d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary mr-1">Filter</button>
                    <a href="{{ route('laporan.mutasi_stok') }}" class="btn btn-secondary mr-1">Reset</a>
                    <a href="{{ route('laporan.mutasi_stok_pdf', ['kategori' => request('kategori'), 'tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir')]) }}"
                        class="btn btn-danger">
                        <i class="fas fa-file-pdf mr-1"></i>PDF
                    </a>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mutasi as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item['kode_produk'] }}</td>
                                <td class="text-left">{{ $item['nama_produk'] }}</td>
                                <td class="text-center">{{ $item['kategori'] }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">{{ $item['jumlah'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
