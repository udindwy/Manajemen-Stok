@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-box"></i>
            {{ $title }}
        </h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('stokkeluar') }}" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-plus fa-sm mr-2"></i>Transaksi
                    </a>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#scannerModal">
                        <i class="fas fa-qrcode fa-sm mr-2"></i>Scan QR Code
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Kode Produk</th>
                                <th>Nama Produk</th>
                                <th width="15%">Kategori</th>
                                <th width="8%">Stok</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $item->kode_produk }}</td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                    <td class="text-center">{{ $item->stok }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scanner Modal -->
    <div class="modal fade" id="scannerModal" tabindex="-1" role="dialog" aria-labelledby="scannerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scannerModalLabel">Scan QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="reader"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="result" class="mt-3">
                                <div class="alert alert-info">
                                    Arahkan kamera ke QR Code produk
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            window.location.href = `/stokkeluar/create?kode_produk=${decodedText}`;
        }

        let html5QrcodeScanner = null;

        $('#scannerModal').on('shown.bs.modal', function(e) {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: 250
                });
            html5QrcodeScanner.render(onScanSuccess);
        });

        $('#scannerModal').on('hidden.bs.modal', function(e) {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }
        });
    </script>
@endsection
