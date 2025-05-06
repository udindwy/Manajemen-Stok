@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-fw fa-users"></i>
            {{ $title }}
        </h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('userCreate') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-2"></i>Tambah Pengguna
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white">
                            <tr class="text-center">
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th width="10%">Role</th>
                                <th width="15%">Dibuat pada</th>
                                <th width="10%">
                                    <i class="fas fa-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengguna as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td class="text-center">{{ $item->peran }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($item->dibuat_pada)->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('userEdit', $item->id_pengguna) }}"
                                            class="btn btn-sm btn-warning mb-1 mr-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger mb-1" data-toggle="modal"
                                            data-target="#exampleModal{{ $item->id_pengguna }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @include('admin.user.modal')
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
