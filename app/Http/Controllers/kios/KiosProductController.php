<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Models\divisi\Divisi;
use App\Http\Controllers\Controller;
use App\Models\produk\ProdukJenis;
use App\Models\produk\ProdukKategori;
use App\Repositories\kios\KiosRepository;

class KiosProductController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $kategori = ProdukKategori::all();

        return view('kios.product.index', [
            'title' => 'Product',
            'active' => 'product',
            'dropdown' => true,
            'kategori' => $kategori,
            'divisi' => $divisiName,
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'kategori_id' => 'required',
            'nama' => 'required',
        ]);

        $validate['nama'] = strtoupper($validate['nama']);
        try{
            ProdukJenis::create($validate);
            return redirect('/kios/product')->with('success', 'Success Create New Product Type.');
        } catch(\Exception $e){
            return redirect('kios/product')->with('error', $e->getMessage());
        }



    }

    public function index_add_part()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);

        return view('kios.product.file-upload', [
            'title' => 'File Upload',
            'active' => 'file-upload',
            'dropdown' => true,
            'divisi' => $divisiName,
        ]);
    }
}
