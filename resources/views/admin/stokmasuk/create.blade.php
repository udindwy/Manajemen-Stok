@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-fw fa-plus"></i> {{ $title }}
        </h1>

        <div class="card shadow mb-4">
            <div class="card-header bg-primary">
                <a href="{{ route('stokmasuk') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('stokmasukStore') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="id_produk" class="form-label">
                                <span class="text-danger">*</span>Produk:
                            </label>
                            <select id="id_produk" name="id_produk"
                                class="form-control @error('id_produk') is-invalid @enderror">
                                <option selected disabled>-- Pilih Produk --</option>
                                @foreach ($produk as $p)
                                    <option value="{{ $p->id_produk }}"
                                        {{ old('id_produk') == $p->id_produk || request('id_produk') == $p->id_produk ? 'selected' : '' }}>
                                        {{ $p->kode_produk }} - {{ $p->nama_produk }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_produk')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-xl-6 mb-3">
                            <label for="jumlah" class="form-label">
                                <span class="text-danger">*</span>Jumlah:
                            </label>
                            <input type="number" id="jumlah" name="jumlah"
                                class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}">
                            @error('jumlah')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="tanggal_masuk" value="{{ date('Y-m-d H:i:s') }}">

                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Set tanggal dan waktu saat ini saat halaman dimuat
        window.onload = function() {
            var now = new Date();
            var year = now.getFullYear();
            var month = String(now.getMonth() + 1).padStart(2, '0');
            var day = String(now.getDate()).padStart(2, '0');
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');

            var datetime = `${year}-${month}-${day}T${hours}:${minutes}`;
            document.getElementById('tanggal_masuk').value = datetime;
        }
    </script>
@endsection
