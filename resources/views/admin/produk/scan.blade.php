@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-qrcode"></i> {{ $title }}
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary">
            <a href="{{ route('produk') }}" class="btn btn-sm btn-success">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
        <div class="card-body">
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
@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        $.ajax({
            url: '{{ route("searchByQR") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                kode_produk: decodedText
            },
            success: function(response) {
                if (response.success) {
                    const produk = response.data;
                    $('#result').html(`
                        <div class="alert alert-success">
                            <h5>Produk Ditemukan:</h5>
                            <p>Kode: ${produk.kode_produk}</p>
                            <p>Nama: ${produk.nama_produk}</p>
                            <p>Stok: ${produk.stok}</p>
                        </div>
                    `);
                } else {
                    $('#result').html(`
                        <div class="alert alert-danger">
                            ${response.message}
                        </div>
                    `);
                }
            }
        });
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection