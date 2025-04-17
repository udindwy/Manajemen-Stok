@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-bell"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header bg-danger text-white">
            <h6 class="m-0 font-weight-bold">Stok Minimum</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-warning">
                Beberapa produk berada di bawah batas stok minimum. Segera lakukan penambahan stok!
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-danger text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Stok Saat Ini</th>
                            <th>Batas Minimum</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>1</td>
                            <td>Teh Botol</td>
                            <td>Minuman</td>
                            <td><span class="badge badge-danger">3</span></td>
                            <td>5</td>
                            <td><span class="badge badge-warning">Stok Minim</span></td>
                        </tr>
                        <tr class="text-center">
                            <td>2</td>
                            <td>Nasi Putih</td>
                            <td>Makanan</td>
                            <td><span class="badge badge-danger">2</span></td>
                            <td>10</td>
                            <td><span class="badge badge-warning">Stok Minim</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
