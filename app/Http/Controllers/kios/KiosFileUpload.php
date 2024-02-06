<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\produk\ProdukJenis;
use App\Repositories\kios\KiosRepository;
use Exception;

class KiosFileUpload extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $jenisDrone = ProdukJenis::with('subjenis.kelengkapans')->get();

        return view('kios.product.file-upload', [
            'title' => 'File Upload',
            'active' => 'file-upload',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'jenisdrone' => $jenisDrone,
        ]);
    }

    public function uploadbaru(Request $request)
    {
        $request->validate([
            'file_paket_produk' => 'image|mimes:jpeg,png,jpg',
            'file_kelengkapan_produk' => 'image|mimes:jpeg,png,jpg',
        ]);

        try {

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function uploadsecond(Request $request)
    {
        
    }

}
