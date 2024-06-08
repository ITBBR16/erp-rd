<?php

namespace App\Http\Controllers\kios;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\produk\ProdukJenis;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosOrderSecond;
use App\Models\kios\KiosQcProdukSecond;
use App\Repositories\kios\KiosRepository;
use Symfony\Component\Console\Input\Input;

class KiosFilterProdukSecondController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $secondOrder = KiosOrderSecond::with('customer', 'subjenis.produkjenis', 'qcsecond.kelengkapans', 'statuspembayaran', 'buymetodesecond')
        ->where('status', 'Done QC')
        ->get();
        
        return view('kios.product.pengecekkan.filter-produk-seconds', [
            'title' => 'Filter Produk Second',
            'active' => 'filter-produk-second',
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
        return view('kios.product.pengecekkan.filtersecond.filter-produk-second', [
            'title' => 'Filter Product Second',
            'active' => 'filter-produk-second',
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
            $statusQc = 'Ready';
            $pivotIds = $request->input('pivot_id');
            $kondisi = $request->input('kondisi');
            $serialNumbers = $request->input('serial_number');
            $keterangan = $request->input('keterangan');
            $nilaiSatuan = preg_replace("/[^0-9]/", "", $request->input('harga_satuan_filter_second'));
            $kiosQcPS = KiosQcProdukSecond::find($id);
            $tanggal = Carbon::now();
            $tanggal->setTimezone('Asia/Jakarta');
            $formattedDate = $tanggal->format('d/m/Y H:i:s');

            foreach ($pivotIds as $index => $pivotId) {
                $data = [
                    'kondisi' => $kondisi[$index],
                    'keterangan' => $keterangan[$index],
                    'harga_satuan' => $nilaiSatuan[$index],
                    'serial_number' => $serialNumbers[$index],
                    'status' => $statusQc,
                ];

                $kiosQcPS->kelengkapans()->where('pivot_qc_id', $pivotId)->update($data);
            }

            if($request->has('kelengkapan_filter_additional')) {
                $additionalKelengkapan = $request->input('kelengkapan_filter_additional');
                $additionalKondisi = $request->input('additional_kondisi');
                $additionalSerialNumber = $request->input('additional_serial_number');
                $additionalKeterangan = $request->input('additional_keterangan');
                $additionalHargaSatuan = $request->input('harga_satuan_filter_second');

                foreach ($additionalKelengkapan as $additional => $idKelengkapan) {
                    $dataAdditional = [
                        'kondisi' => $additionalKondisi[$additional],
                        'keterangan' => $additionalKeterangan[$additional],
                        'harga_satuan' => $additionalHargaSatuan[$additional],
                        'serial_number' => $additionalSerialNumber[$additional],
                        'status' => $statusQc
                    ];

                    $kiosQcPS->kelengkapans()->attach($idKelengkapan, $dataAdditional);
                }
            }

            if($request->has('exclude_kelengkapan_filter_additional')) {
                $produkJenisId = $request->input('produk_jenis_id');
                $type = ProdukJenis::findOrFail($produkJenisId);

                $excludeKelengkapan = $request->input('exclude_kelengkapan_filter_additional');
                $excludeKondisi = $request->input('exclude_kondisi');
                $excludeSerialNumber = $request->input('exclude_serial_number');
                $excludeKeterangan = $request->input('exclude_keterangan');
                $excludeHargaSatuan = $request->input('harga_satuan_exclude');

                $formatedKelengkapan = collect($excludeKelengkapan)->map(function ($jk) {
                    return ['kelengkapan' => ucwords(strtolower($jk))];
                });

                $kelengkapanBaru = $type->kelengkapans()->createMany($formatedKelengkapan->toArray());
                $kelengkapanBaruId = $kelengkapanBaru->pluck('id')->toArray();

                
                foreach($kelengkapanBaruId as $index => $idBaru) {
                    $dataExclude = [
                        'kondisi' => $excludeKondisi[$index],
                        'keterangan' => $excludeKeterangan[$index],
                        'harga_satuan' => $excludeHargaSatuan[$index],
                        'serial_number' => $excludeSerialNumber[$index],
                        'status' => $statusQc
                    ];
                    $kiosQcPS->kelengkapans()->attach($idBaru, $dataExclude);
                }
            }

            $orderSecondId = $kiosQcPS->order_second_id;
            $orderSecond = KiosOrderSecond::findOrFail($orderSecondId);
            $orderSecond->status = 'InRD';
            $orderSecond->save();

            $kiosQcPS->tanggal_filter = $formattedDate;
            $kiosQcPS->save();

            $connectionKios->commit();
            $connectionProduk->commit();
            return redirect()->route('filter-product-second.index')->with('success', 'Success Input Filter Result.');

        } catch (Exception $e) {
            $connectionKios->rollBack();
            $connectionProduk->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

}
