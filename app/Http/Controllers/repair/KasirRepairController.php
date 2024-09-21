<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Repositories\logistik\repository\EkspedisiRepository;
use App\Repositories\repair\repository\RepairCustomerRepository;

class KasirRepairController extends Controller
{
    protected $caseService;
    public function __construct(private UmumRepository $nameDivisi, private RepairCustomerRepository $repairCustomer, private EkspedisiRepository $ekspedisiRepository, RepairCaseService $repairCaseService)
    {
        $this->caseService = $repairCaseService;
    }

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataProvinsi = $this->repairCustomer->getProvinsi();
        $caseService = $this->caseService->getDataDropdown();
        $dataEkspedisi = $this->ekspedisiRepository->getDataEkspedisi();
        $dataCase = $caseService['data_case'];

        return view('repair.csr.kasir-repair', [
            'title' => 'List Kasir Repair',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataProvinsi' => $dataProvinsi,
            'dataCase' => $dataCase,
            'dataEkspedisi' => $dataEkspedisi,
        ]);

    }

    public function edit($id)
    {
        $user = auth()->user();
        $idCase = decrypt($id);
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataCase = $this->caseService->findCase($idCase);
        $daftarAkun = $this->caseService->getDataAkun();

        return view('repair.csr.edit.kasir-pelunasan', [
            'title' => 'Kasir Pelunasan Repair',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'daftarAkun' => $daftarAkun,
        ]);
    }

    public function downpaymentKasir($encryptId)
    {
        $user = auth()->user();
        $idCase = decrypt($encryptId);
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataCase = $this->caseService->findCase($idCase);
        $daftarAkun = $this->caseService->getDataAkun();

        return view('repair.csr.edit.kasir-dp', [
            'title' => 'Kasir DP Repair',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'daftarAkun' => $daftarAkun,
        ]);
    }

    public function createPelunasan(Request $request, $id)
    {
        $resultPelunasan = $this->caseService->createPelunasan($request, $id);

        if ($resultPelunasan['status'] == 'success') {
            return redirect()->route('kasir-repair.index')->with('success', $resultPelunasan['message']);
        } else {
            return back()->with('error', $resultPelunasan['message']);
        }
    }

    public function createPembayaran(Request $request, $id)
    {
        $resultPembayaran = $this->caseService->createPembayaran($request, $id);

        if ($resultPembayaran['status'] == 'success') {
            return redirect()->route('kasir-repair.index')->with('success', $resultPembayaran['message']);
        } else {
            return back()->with('error', $resultPembayaran['message']);
        }
    }

    public function createOngkirKasir(Request $request, $id)
    {
        $resultOngkir = $this->caseService->createOngkirKasir($request, $id);

        if ($resultOngkir['status'] == 'success') {
            return back()->with('success', $resultOngkir['message']);
        } else {
            return back()->with('error', $resultOngkir['message']);
        }
    }

    public function previewPdfPelunasan($id)
    {
        $dataCase = $this->caseService->findCase($id);
        $data = [
            'title' => 'Preview Pelunasan',
            'dataCase' => $dataCase,
        ];

        // return view('repair.csr.invoice.invoice-pelunasan', $data);

        $pdf = Pdf::loadView('repair.csr.invoice.invoice-pelunasan', $data);
        return $pdf->stream();
    }

    public function previewPdfDp($id)
    {
        $dataCase = $this->caseService->findCase($id);
        $data = [
            'title' => 'Preview Down Payment',
            'dataCase' => $dataCase,
        ];

        // return view('repair.csr.invoice.invoice-dp', $data);

        $pdf = Pdf::loadView('repair.csr.invoice.invoice-dp', $data);
        return $pdf->stream();
    }

    public function getDataCustomer($id)
    {
        return $this->repairCustomer->findCustomer($id);
    }

    public function getLayanan($id)
    {
        return $this->ekspedisiRepository->getDataLayanan($id);
    }

}
