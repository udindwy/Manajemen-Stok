@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-fw fa-tags"></i>
            {{ $title }}
        </h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <a href="{{ route('kategoriCreate') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus fa-sm mr-2"></i>Tambah Kategori
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kategori</th>
                                <th width="20%">Dibuat Pada</th>
                                <th width="10%"><i class="fas fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategori as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_kategori }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($item->dibuat_pada)->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('kategoriEdit', $item->id_kategori) }}"
                                            class="btn btn-warning btn-sm mb-1 mr-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm mb-1" data-toggle="modal"
                                            data-target="#modalHapusKategori{{ $item->id_kategori }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @include('admin.kategori.modal')
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
