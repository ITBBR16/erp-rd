<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\kios\KiosRepository;

class KiosFileUpload extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);

        return view('kios.product.file-upload', [
            'title' => 'File Upload',
            'active' => 'file-upload',
            'dropdown' => true,
            'dropdownShop' => '',
            'divisi' => $divisiName,
        ]);
    }
}
