<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosOrderSecond;
use App\Models\kios\KiosQcProdukSecond;
use App\Models\produk\ProdukKelengkapan;
use App\Models\produk\ProdukSubJenis;
use App\Repositories\umum\UmumRepository;

class KiosPengecekkanSecondController extends Controller
{
    public function __construct(
        private UmumRepository $umum
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $secondOrder = KiosOrderSecond::where('status', 'Proses QC')->get();

        return view('kios.product.pengecekkan.index-pengecekkan-second', [
            'title' => 'Pengecekkan Second',
            'active' => 'pengecekkan-second',
            'navActive' => 'product',
            'dropdown' => 'pengecekkan-second',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'orderSecond' => $secondOrder,
        ]);
    }

    public function edit($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $kos = KiosOrderSecond::findOrFail($id);
        return view('kios.product.pengecekkan.qc-second.qc-second', [
            'title' => 'Quality Control Second',
            'active' => 'pengecekkan-second',
            'navActive' => 'product',
            'divisi' => $divisiName,
            'dropdown' => 'pengecekkan-second',
            'dropdownShop' => '',
            'kos' => $kos,
        ]);
    }

    public function update(Request $request, $id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionProduk = DB::connection('rumahdrone_produk');
        $connectionKios->beginTransaction();
        $connectionProduk->beginTransaction();

        try {
            $statusQc = 'Done QC';
            $orderId = $request->input('order_second_id');
            $customerId = $request->input('customer_id');
            $customSN = 'S' . $orderId . $customerId;
            $pivotIds = $request->input('pivot_id');
            $serialNumbers = $request->input('serial_number');
            $keterangan = $request->input('keterangan');
            $kondisi = $request->input('kondisi');
            $kiosQcPS = KiosQcProdukSecond::findOrFail($id);
            $tanggal = Carbon::now();
            $tanggal->setTimezone('Asia/Jakarta');
            $formattedDate = $tanggal->format('d/m/Y H:i:s');

            foreach ($pivotIds as $index => $pivotId) {
                $data = [
                    'kondisi' => $kondisi[$index],
                    'keterangan' => $keterangan[$index],
                    'harga_satuan' => '0',
                    'serial_number' => ($serialNumbers[$index] != "") ? $serialNumbers[$index] : $customSN . $pivotId,
                    'status' => $statusQc,
                ];

                $kiosQcPS->kelengkapans()->where('pivot_qc_id', $pivotId)->update($data);
            }

            if($request->has('kelengkapan_qc_additional')) {
                $additionalKelengkapan = $request->input('kelengkapan_qc_additional');
                $additionalKondisi = $request->input('additional_kondisi');
                $additionalSerialNumber = $request->input('additional_serial_number');
                $additionalKeterangan = $request->input('additional_keterangan');

                foreach ($additionalKelengkapan as $additional => $idKelengkapan) {
                    $dataAdditional = [
                        'kondisi' => $additionalKondisi[$additional],
                        'keterangan' => $additionalKeterangan[$additional],
                        'harga_satuan' => 0,
                        'serial_number' => $additionalSerialNumber[$additional],
                        'status' => $statusQc
                    ];

                    $kiosQcPS->kelengkapans()->attach($idKelengkapan, $dataAdditional);

                }
                
            }

            $orderSecondId = $kiosQcPS->order_second_id;
            $orderSecond = KiosOrderSecond::findOrFail($orderSecondId);
            $orderSecond->status = $statusQc;
            $orderSecond->save();

            $kiosQcPS->tanggal_qc = $formattedDate;
            $kiosQcPS->save();

            if($request->has('exclude_kelengkapan_qc_additional')) {
                $subJenisId = $request->input('paket_penjualan_id');
                $searchSubjenis = ProdukSubJenis::findOrFail($subJenisId);
                $produkJenisList = $searchSubjenis->produkjenis;

                $excludeKelengkapan = $request->input('exclude_kelengkapan_qc_additional');
                $excludeKondisi = $request->input('exclude_kondisi');
                $excludeSerialNumber = $request->input('exclude_serial_number');
                $excludeKeterangan = $request->input('exclude_keterangan');

                $formatedKelengkapan = collect($excludeKelengkapan)->map(function ($jk) {
                    return ['kelengkapan' => ucwords(strtolower($jk))];
                });

                $kelengkapanBaru = ProdukKelengkapan::createMany($formatedKelengkapan->toArray());
                $kelengkapanBaruId = $kelengkapanBaru->pluck('id')->toArray();

                foreach ($kelengkapanBaruId as $index => $idBaru) {
                    $dataExclude = [
                        'kondisi' => $excludeKondisi[$index],
                        'keterangan' => $excludeKeterangan[$index],
                        'harga_satuan' => 0,
                        'serial_number' => $excludeSerialNumber[$index],
                        'status' => $statusQc
                    ];
                    $kiosQcPS->kelengkapans()->attach($idBaru, $dataExclude);
                    foreach ($produkJenisList as $produkJenis) {
                        $produkJenis->kelengkapans()->attach($idBaru);
                    }
                }
            }

            $connectionKios->commit();
            $connectionProduk->commit();
            return redirect()->route('pengecekkan-produk-second.index')->with('success', 'Success Input QC Result.');

        } catch (Exception $e) {
            $connectionKios->rollBack();
            $connectionProduk->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

}
