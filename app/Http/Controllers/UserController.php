<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kelola Pengguna',
            "MUser" => "active",
        ];
        return view('admin.user.index', $data);
    }
}
