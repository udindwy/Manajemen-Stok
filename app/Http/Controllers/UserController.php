<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kelola Pengguna',
            'MUser' => 'active',
            'pengguna'  => Pengguna::get(),
        ];
        return view('admin.user.index', $data);
    }
}
