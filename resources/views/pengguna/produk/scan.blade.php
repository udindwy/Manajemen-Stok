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
        // Redirect langsung ke form stok keluar dengan kode produk
        window.location.href = `/stokkeluar/create?kode_produk=${decodedText}`;
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection