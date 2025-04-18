@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-tags"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="#" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Kategori
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Dibuat Pada</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-left">{{ $item->nama_kategori }}</td>
                                <td>{{ $item->dibuat_pada }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
