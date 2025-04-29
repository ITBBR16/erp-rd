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
    public function __construct(
        private UmumRepository $nameDivisi,
        private RepairCustomerRepository $repairCustomer,
        private RepairCaseService $caseService)
    {}

    public function index()
    {
        return $this->caseService->indexKasir();
    }

    public function detailKasir($encryptId)
    {
        return $this->caseService->pageDetailKasir($encryptId);
    }

    public function edit($id)
    {
        return $this->caseService->pagePelunasan($id);
    }

    public function pageOngkirKasir($encryptId)
    {
        return $this->caseService->pageInputOngkir($encryptId);
    }

    public function downpaymentKasir($encryptId)
    {
        return $this->caseService->pageDp($encryptId);
    }

    public function createPelunasan(Request $request, $id)
    {
        $resultPelunasan = $this->caseService->createPelunasan($request, $id);

        if ($resultPelunasan['status'] == 'success') {
            return redirect()->route('kasir-repair.index')->with($resultPelunasan['status'], $resultPelunasan['message']);
        } else {
            return back()->with($resultPelunasan['status'], $resultPelunasan['message']);
        }
    }

    public function createPembayaran(Request $request, $id)
    {
        $resultPembayaran = $this->caseService->createPembayaran($request, $id);

        if ($resultPembayaran['status'] == 'success') {
            return redirect()->route('kasir-repair.index')->with($resultPembayaran['status'], $resultPembayaran['message']);
        } else {
            return back()->with($resultPembayaran['status'], $resultPembayaran['message']);
        }
    }

    public function konfirmasiAlamat($id)
    {
        $resultKonfirmasiAlamat = $this->caseService->sendKonfirmasiAlamat($id);
        return back()->with($resultKonfirmasiAlamat['status'], $resultKonfirmasiAlamat['message']);
    }

    public function createOngkirKasir(Request $request, $id)
    {
        $resultOngkir = $this->caseService->createOngkirKasir($request, $id);
        if ($resultOngkir['status'] == 'success') {
            return redirect()->route('kasir-repair.index')->with($resultOngkir['status'], $resultOngkir['message']);
        } else {
            return back()->with($resultOngkir['status'], $resultOngkir['message']);
        }
    }

    public function previewPdfPelunasan($id)
    {
        $dataCase = $this->caseService->findCase($id);
        $data = [
            'title' => 'Preview Pelunasan',
            'dataCase' => $dataCase,
        ];

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

        $pdf = Pdf::loadView('repair.csr.invoice.invoice-dp', $data);
        return $pdf->stream();
    }

    public function getDataCustomer($id)
    {
        return $this->repairCustomer->findCustomer($id);
    }

    public function getLayanan($id)
    {
        return $this->caseService->getLayanan($id);
    }

}
