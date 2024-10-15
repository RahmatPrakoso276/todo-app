<?php

namespace App\Http\Controllers\belajar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class viewcontroller extends Controller
{
    //
    public function index()
    {
        $nama = 'Rahmat';
        $nim = 2020276;
        $data = [
            'nama_mhs' => $nama,
            'nim_mhs' => $nim,
        ];
        return view("components.app", $data);
    }

    
}
