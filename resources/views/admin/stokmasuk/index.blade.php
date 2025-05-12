@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-fw fa-arrow-down"></i>
            {{ $title }}
        </h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('stokmasukCreate') }}" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-plus fa-sm mr-2"></i>Tambah Stok Masuk
                    </a>
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#scannerModal">
                        <i class="fas fa-qrcode fa-sm mr-2"></i>Scan QR Code
                    </button>
                </div>
            </div>

            <!-- Modal Scanner -->
            <div class="modal fade" id="scannerModal" tabindex="-1" role="dialog" aria-labelledby="scannerModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="scannerModalLabel">Scan QR Code Produk</h5>
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

        @section('scripts')
            <script src="https://unpkg.com/html5-qrcode"></script>
            <script>
                function onScanSuccess(decodedText, decodedResult) {
                    console.log("Scanned QR Code:", decodedText);

                    const url = `/stokmasuk/get-product/${decodedText}`;

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            if (response.success) {
                                const produk = response.data;
                                $('#scannerModal').modal('hide');
                                if (html5QrcodeScanner) {
                                    html5QrcodeScanner.clear();
                                }
                                window.location.href = '{{ route('stokmasukCreate') }}?id_produk=' + produk.id_produk;
                            } else {
                                $('#result').html(`
                                    <div class="alert alert-danger">
                                        ${response.message}
                                    </div>
                                `);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Ajax Error:", error); // Tambahkan log untuk debugging
                            $('#result').html(`
                                <div class="alert alert-danger">
                                    Terjadi kesalahan saat memproses QR code
                                </div>
                            `);
                        }
                    });
                }

                let html5QrcodeScanner;

                $('#scannerModal').on('shown.bs.modal', function() {
                    html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", {
                            fps: 10,
                            qrbox: {
                                width: 250,
                                height: 250
                            },
                            experimentalFeatures: {
                                useBarCodeDetectorIfSupported: true
                            },
                            rememberLastUsedCamera: true,
                        }
                    );
                    html5QrcodeScanner.render(onScanSuccess);
                });

                $('#scannerModal').on('hidden.bs.modal', function() {
                    if (html5QrcodeScanner) {
                        html5QrcodeScanner.clear();
                    }
                });
            </script>
        @endsection

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th width="12%">Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Supplier</th>
                            <th width="10%">Jumlah Masuk</th>
                            <th>Nama Pengguna</th>
                            <th width="15%">Tanggal Masuk</th>
                            <th width="10%"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stokMasuk as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->produk->kode_produk }}</td>
                                <td>{{ $item->produk->nama_produk }}</td>
                                <td>{{ $item->produk->kategori->nama_kategori }}</td>
                                <td>{{ $item->produk->supplier->nama_supplier ?? '-' }}</td>
                                <td class="text-center">{{ $item->jumlah }}</td>
                                <td>{{ $item->pengguna->nama }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('stokmasukEdit', $item->id_stok_masuk) }}"
                                            class="btn btn-warning btn-sm mr-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modalHapusStokMasuk{{ $item->id_stok_masuk }}"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    @include('admin.stokmasuk.modal')
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
