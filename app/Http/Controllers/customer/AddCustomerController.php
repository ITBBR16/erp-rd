<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\customer\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AddCustomerController extends Controller
{
    public function index()
    {
        $url = 'https://itbbr16.github.io/api-wilayah-indonesia/api/provinces.json';

        $provinsi = json_decode(file_get_contents($url), true);

        return view('customer.main.add-customer', [
            'title' => 'Add Customer',
            'active' => 'add-customer',
            'provinsi' => $provinsi
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'floating_first_name' => 'required|max:50',
            'floating_last_name' => 'required|max:50',
            'floating_telp' => 'required|max:15',
            'floating_email' => 'email:dns',
            'floating_instansi' => 'max:50',
            'select_provinsi' => 'required|int',
            'select_kota_kab' => 'required|int',
            'select_kecamatan' => 'required|int',
            'select_kelurahan' => 'required|int',
            'floating_kode_pos' => 'required|int|min:5|max:5',
            'floating_addres' => 'required|max:255'
        ]);

        return $validate;

        // $provinsiName = $this->getNameProv($request->input('select_provinsi'));
        // $kotaName = $this->getNameKota($request->input('select_kota_kab'));
        // $kecamatanName = $this->getNameKecamatan($request->input('select_kecamatan'));
        // $kelurahanName = $this->getNameKelurahan($request->input('select_kelurahan'));

        // $customer = new Customer();
        // $customer->first_name = $request->input('floating_first_name');
        // $customer->last_name = $request->input('floating_last_name');
        // $customer->telp = $request->input('floating_telp');
        // $customer->email = $request->input('floating_email');
        // $customer->instansi = $request->input('floating_instansi');
        // $customer->kode_pos = $request->input('floating_kode_pos');
        // $customer->address = $request->input('floating_addres');

        // $customer->provinsi = $provinsiName;
        // $customer->kota_kab = $kotaName;
        // $customer->kecamatan = $kecamatanName;
        // $customer->kelurahan = $kelurahanName;

        // dd($customer);
    }

    private function getNameProv($id)
    {
        $resp = Http::get('https://itbbr16.github.io/api-wilayah-indonesia/api/provinces.json');
        $data = $resp->json();

        foreach ($data as $prov) {
            if($prov['id'] == $id) {
                return $prov['name'];
            }
        }
    }

    private function getNameKota($id)
    {
        $resp = Http::get("https://itbbr16.github.io/api-wilayah-indonesia/api/districts/$id.json");
        $data = $resp->json();

        foreach ($data as $kota) {
            if($kota['id'] == $id) {
                return $kota['name'];
            }
        }
    }

    private function getNameKecamatan($id)
    {
        $resp = Http::get("https://itbbr16.github.io/api-wilayah-indonesia/api/districts/$id.json");
        $data = $resp->json();

        foreach ($data as $kec) {
            if($kec['id'] == $id) {
                return $kec['name'];
            }
        }
    }

    private function getNameKelurahan($id)
    {
        $resp = Http::get("https://itbbr16.github.io/api-wilayah-indonesia/api/villages/$id.json");
        $data = $resp->json();

        foreach ($data as $kel) {
            if($kel['id'] == $id) {
                return $kel['name'];
            }
        }
    }

    public function getKota($provinsiId)
    {
        $url = "https://itbbr16.github.io/api-wilayah-indonesia/api/regencies/$provinsiId.json";

        $kota = json_decode(file_get_contents($url), true);

        if (count($kota) > 0) {
            return response()->json($kota);
        }
    }

    public function getKecamatan($kotaId) 
    {
        $url = "https://itbbr16.github.io/api-wilayah-indonesia/api/districts/$kotaId.json";

        $kecamatan = json_decode(file_get_contents($url), true);

        if (count($kecamatan) > 0) {
            return response()->json($kecamatan);
        }
    }

    public function getKelurahan($kecamatanId) 
    {
        $url = "https://itbbr16.github.io/api-wilayah-indonesia/api/villages/$kecamatanId.json";

        $kelurahan = json_decode(file_get_contents($url), true);

        if (count($kelurahan) > 0) {
            return response()->json($kelurahan);
        }
    }
}
