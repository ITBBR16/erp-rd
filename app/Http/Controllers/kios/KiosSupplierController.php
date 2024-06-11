<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\kios\SupplierKios;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProduk;
use App\Models\produk\ProdukKategori;
use App\Repositories\kios\KiosRepository;

class KiosSupplierController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);

        $kategori = ProdukKategori::all();
        $suppliers = SupplierKios::with('kategoris')->get();
        
        return view('kios.supplier.supplier', [
            'title' => 'Supplier',
            'active' => 'supplier',
            'navActive' => 'product',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'kategori' => $kategori,
            'suppliers' => $suppliers,
        ]);
    }

    public function edit($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $suppliers = SupplierKios::findOrFail($id);
        $product = KiosProduk::all();

        return view('kios.supplier.modal.support-supp', [
            'title' => 'Support Supplier',
            'active' => 'supplier',
            'navActive' => 'product',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => '',
            'suppliers' => $suppliers,
            'products' => $product,
        ]);
    }


    public function store(Request $request)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        try {
            $request->validate([
                'pic_name' => 'required',
                'nama_perusahaan' => 'required',
                'npwp' => 'required',
                'no_telpon' => ['required', 'regex:/^62\d{9,}$/', Rule::unique('rumahdrone_kios.supplier_kios', 'no_telpon')],
                'alamat_lengkap' => 'required',
                'kategori' => 'required|array|min:1',
            ]);
            $supplier = SupplierKios::create([
                'pic_name' => $request->pic_name,
                'nama_perusahaan' => $request->nama_perusahaan,
                'npwp' => $request->npwp,
                'no_telpon' => $request->no_telpon,
                'alamat_lengkap' => $request->alamat_lengkap,
            ]);
    
            $supplier->kategoris()->sync($request->input('kategori'));
            
            $connectionKios->commit();
            return back()->with('success', 'Success Add New Supplier.');

        } catch(Exception $e) {
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        try {
            $rules = [
                'pic_name' => 'required',
                'nama_perusahaan' => 'required',
                'npwp' => 'required',
                'alamat_lengkap' => 'required',
            ];

            $request->validate([
                'kategori' => 'required|array|min:1',
            ]);

            $supplier = SupplierKios::findOrFail($id);

            if($request->no_telpon != $supplier->no_telpon){
                $rules['no_telpon'] = ['required', 'regex:/^62\d{9,}$/', Rule::unique('rumahdrone_kios.supplier_kios', 'no_telpon')];
            }

            $validate = $request->validate($rules);
            $supplier->update($validate);

            $supplier->kategoris()->sync($request->input('kategori', []));

            $connectionKios->commit();
            return back()->with('success', 'Success Update Data Supplier');
        } catch(Exception $e){
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }

    }

    public function destroy($id)
    {
        try{
            $supplier = SupplierKios::findOrFail($id);
            $supplier->kategoris()->detach();
            $supplier->delete();

            return back()->with('success', 'Success Delete Supplier.');
        } catch(Exception $e){
            return back()->with('error', $e->getMessage());
        }

    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $dataCustomer = SupplierKios::where(function($q) use ($query) {
                $q->where('pic_name', 'like', "%$query%")
                ->orWhere('nama_perusahaan', 'like', "%$query%")
                ->orWhereRaw("CONCAT(pic_name, ' ', nama_perusahaan) LIKE ?", ["%$query%"]);
            })
            ->orWhere('npwp', 'like', "%$query%")
            ->paginate(10);

        return response()->json($dataCustomer);
    }

}
