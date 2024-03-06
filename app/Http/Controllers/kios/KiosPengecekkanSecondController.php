<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\produk\ProdukJenis;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosOrderSecond;
use App\Models\kios\KiosQcProdukSecond;
use App\Repositories\kios\KiosRepository;

class KiosPengecekkanSecondController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $secondOrder = KiosOrderSecond::with('customer', 'subjenis.produkjenis', 'qcsecond.kelengkapans', 'statuspembayaran', 'buymetodesecond')
        ->where('status', 'Proses QC')
        ->get();
        
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
        $divisiName = $this->suppKiosRepo->getDivisi($user);
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
        try {
            $statusQc = 'Done QC';
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
                    'serial_number' => $serialNumbers[$index],
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
                $produkJenisId = $request->input('produk_jenis_id');
                $type = ProdukJenis::findOrFail($produkJenisId);

                $excludeKelengkapan = $request->input('exclude_kelengkapan_qc_additional');
                $excludeKondisi = $request->input('exclude_kondisi');
                $excludeSerialNumber = $request->input('exclude_serial_number');
                $excludeKeterangan = $request->input('exclude_keterangan');

                $formatedKelengkapan = collect($excludeKelengkapan)->map(function ($jk) {
                    return ['kelengkapan' => ucwords(strtolower($jk))];
                });

                $kelengkapanBaru = $type->kelengkapans()->createMany($formatedKelengkapan->toArray());
                $kelengkapanBaruId = $kelengkapanBaru->pluck('id')->toArray();

                
                foreach($kelengkapanBaruId as $index => $idBaru) {
                    $dataExclude = [
                        'kondisi' => $excludeKondisi[$index],
                        'keterangan' => $excludeKeterangan[$index],
                        'harga_satuan' => 0,
                        'serial_number' => $excludeSerialNumber[$index],
                        'status' => $statusQc
                    ];
                    $kiosQcPS->kelengkapans()->attach($idBaru, $dataExclude);
                }
            }

            return redirect()->route('pengecekkan-produk-second.index')->with('success', 'Success Input QC Result.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
