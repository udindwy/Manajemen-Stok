@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-fw fa-users"></i>
        {{ $title }}
    </h1>

    <div class="card">
        <div class="card-header">
            <div>
                <a href="" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-2"></i>Tambah Data</a>
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
                            <tr>
                                <td>1</td>
                                <td>Wahyualex</td>
                                <td>udin.dwi@students.utdi.ac.id</td>
                                <td class="text-center">
                                    <span class="badge badge-dark badge-pill">Admin</span>
                                </td>
                                <td>2025-04-16</td>
                                <td class="text-center">
                                    <a href="" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
