<?php

namespace App\Http\Controllers\repair;

use App\Http\Controllers\Controller;
use App\Models\divisi\Divisi;
use App\Models\management\AkuntanDaftarAkun;
use App\Repositories\logistik\repository\EkspedisiRepository;
use App\Repositories\repair\repository\RepairCustomerRepository;
use App\Repositories\umum\UmumRepository;
use App\Services\logistik\LogistikServices;
use Illuminate\Http\Request;

class RepairRequestPackingController extends Controller
{
    public function __construct(
        private Divisi $divisi,
        private UmumRepository $umumRepo,
        private AkuntanDaftarAkun $daftarAkun,
        private LogistikServices $logistikServices,
        private EkspedisiRepository $ekspedisiRepo,
        private RepairCustomerRepository $repairCustomerRepo,
    ){}

    public function index()
    {
        $user = auth()->user();
        $dataDivisi = $this->divisi->all();
        $divisiName = $this->umumRepo->getDivisi($user);
        $dataProvinsi = $this->repairCustomerRepo->getProvinsi();
        $dataCustomer = $this->repairCustomerRepo->getDataCustomer();
        $dataEkspedisi = $this->ekspedisiRepo->getDataEkspedisi();
        $daftarAkun = $this->daftarAkun->where('kode_akun', 'like', '111%')->get();

        $dataCustomers = $dataCustomer->map(function ($customer) {
            return [
                'id' => $customer->id,
                'display' => "{$customer->first_name} {$customer->last_name} - {$customer->id}"
            ];
        });

        return view('repair.csr.form-request-packing', [
            'title' => 'Form Request Packing',
            'active' => 'kasir-frp',
            'navActive' => 'csr',
            'divisi' => $divisiName,
            'dataProvinsi' => $dataProvinsi,
            'dataEkspedisi' => $dataEkspedisi,
            'dataCustomers' => $dataCustomers,
            'dataDivisi' => $dataDivisi,
            'daftarAkun' => $daftarAkun,
        ]);
    }

    public function store(Request $request)
    {
        $result = $this->logistikServices->storeReqPacking($request);
        return back()->with($result['status'], $result['message']);
    }
}
