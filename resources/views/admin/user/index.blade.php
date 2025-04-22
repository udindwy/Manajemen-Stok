@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-users"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header">
            <div>
                <a href="{{ route('userCreate') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-2"></i>Tambah Pengguna</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat pada</th>
                                <th>
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
                                    <td class="text-center">
                                        @if ($item->peran == 'admin')
                                            <span class="badge badge-info">{{ $item->peran }}</span>
                                        @elseif ($item->peran == 'pengguna')
                                            <span class="badge badge-primary">{{ $item->peran }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->dibuat_pada }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('userEdit', $item->id_pengguna) }}"
                                            class="btn btn-sm btn-warning">
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
    </div>
@endsection
