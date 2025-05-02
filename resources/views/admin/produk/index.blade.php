@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-fw fa-box"></i> {{ $title }}
        </h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <a href="{{ route('produkCreate') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus fa-sm mr-2"></i>Tambah Produk
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="12%">Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th width="8%">Stok</th>
                                <th width="10%">Stok Minimal</th>
                                <th>Deskripsi</th>
                                <th width="10%">QR Code</th>
                                <th width="15%">Dibuat pada</th>
                                <th width="10%"><i class="fas fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $item)
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td class="text-center align-middle">{{ $item->kode_produk }}</td>
                                    <td class="text-left align-middle">{{ $item->nama_produk }}</td>
                                    <td class="text-left align-middle">{{ $item->kategori->nama_kategori }}</td>
                                    <td class="text-center align-middle">{{ $item->stok }}</td>
                                    <td class="text-center align-middle">{{ $item->stok_minimal }}</td>
                                    <td class="text-left align-middle">{{ $item->deskripsi }}</td>
                                    <td class="text-center align-middle">
                                        <a href="#" onclick="downloadQR('{{ $item->kode_produk }}', '{{ $item->nama_produk }}')"
                                            title="Klik untuk download QR Code">
                                            {!! $item->qr_code !!}
                                        </a>
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ \Carbon\Carbon::parse($item->dibuat_pada)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('produkEdit', $item->id_produk) }}"
                                            class="btn btn-sm btn-warning mb-1 mr-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger mb-1" data-toggle="modal"
                                            data-target="#modalHapusProduk{{ $item->id_produk }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @include('admin.produk.modal')
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

@section('scripts')
    <script>
        function downloadQR(kode, nama) {
            const svg = event.target.closest('a').querySelector('svg');
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            canvas.width = svg.width.baseVal.value;
            canvas.height = svg.height.baseVal.value;

            const img = new Image();
            const svgData = new XMLSerializer().serializeToString(svg);
            const svgBlob = new Blob([svgData], {
                type: 'image/svg+xml;charset=utf-8'
            });
            const url = URL.createObjectURL(svgBlob);

            img.onload = function() {
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0);

                const link = document.createElement('a');
                link.download = `QR-${kode}-${nama}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();

                URL.revokeObjectURL(url);
            }

            img.src = url;
            event.preventDefault();
        }
    </script>
@endsection
