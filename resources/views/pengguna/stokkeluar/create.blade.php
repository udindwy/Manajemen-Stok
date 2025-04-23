@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-arrow-up"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('stokkeluarStore') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="id_produk">Produk</label>
                    <select name="id_produk" id="id_produk" class="form-control @error('id_produk') is-invalid @enderror">
                        <option value="">--Pilih Produk--</option>
                        @foreach ($produk as $item)
                            <option value="{{ $item->id_produk }}"
                                {{ old('id_produk') == $item->id_produk ? 'selected' : '' }}>
                                {{ $item->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_produk')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah"
                        class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" required
                        min="1">
                    @error('jumlah')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_keluar">Tanggal Keluar</label>
                    <input type="datetime-local" name="tanggal_keluar"
                        class="form-control @error('tanggal_keluar') is-invalid @enderror"
                        value="{{ old('tanggal_keluar') }}">
                    @error('tanggal_keluar')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
