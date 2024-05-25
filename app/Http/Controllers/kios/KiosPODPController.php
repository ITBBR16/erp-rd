<?php

namespace App\Http\Controllers\kios;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\kios\KiosAkunRD;
use App\Models\kios\KiosProduk;
use App\Models\customer\Customer;
use App\Models\kios\KiosTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukSecond;
use App\Models\kios\KiosTransaksiDPPO;
use App\Models\kios\KiosTransaksiDetail;
use App\Repositories\kios\KiosRepository;

class KiosPODPController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $today = Carbon::now();
        $dueDate = $today->copy()->addMonth(3);
        $customerData = Customer::all();
        $akunRd = KiosAkunRD::all();
        $dataTransaksi = KiosTransaksi::orderBy('id', 'desc')->get();
        $invoiceId = $dataTransaksi->first()->id;

        return view('kios.kasir.dppo', [
            'title' => 'DP / PO Kios',
            'active' => 'dp-po-kios',
            'navActive' => 'kasir',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => '',
            'today' => $today,
            'duedate' => $dueDate,
            'customerdata' => $customerData,
            'akunrd' => $akunRd,
            'dataTransaksi' => $dataTransaksi,
            'invoiceid' => $invoiceId,
        ]);
    }

    public function store(Request $request)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        try {
            $userId = auth()->id();
            $validatedData = $request->validate($this->rulesValidasi());

            $totalNominal = 0;
            $dppoStatus = $validatedData['status_dppo'];
            $dppoCustomer = $validatedData['dppo_nama_customer'];
            $dppoPembayaran = $validatedData['dppo_metode_pembayaran'];
            $dppoNominal = $this->sanitizeNominal($request->input('dppo_nominal'));

            $dppoJenisTransaksi = $validatedData['dppo_jenis_transaksi'];
            $dppoIdProduk = $validatedData['dppo_id_produk'];
            $dppoQtyProduk = $validatedData['dppo_qty_produk'];
            $dppoHargaProduk = array_map([$this, 'sanitizeNominal'], $validatedData['dppo_harga']);

            $dppoTransaksi = $this->buatTransaksi($userId, $dppoCustomer, $dppoPembayaran);

            foreach ($dppoIdProduk as $index => $item) {
                $qtyitem = $dppoQtyProduk[$index];
                for ($i = 0; $i < $qtyitem; $i++) {
                    $totalNominal += $dppoHargaProduk[$index];
                    $this->buatDetailTransaksi($dppoTransaksi->id, $dppoJenisTransaksi[$index], $item, $dppoHargaProduk[$index]);
                }
            }

            $this->updateStatusTransaksi($dppoTransaksi, $dppoStatus, $dppoNominal, $totalNominal);

            $connectionKios->commit();
            return back()->with('success', 'Berhasil membuat ' . $dppoStatus);

        } catch (\Exception $e) {
            $connectionKios->rollBack();
            Log::error('Kesalahan saat membuat transaksi: ', ['error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    private function rulesValidasi()
    {
        return [
            'status_dppo' => 'required',
            'dppo_nama_customer' => 'required',
            'dppo_metode_pembayaran' => 'required',
            'dppo_jenis_transaksi' => 'required|array|min:1',
            'dppo_id_produk' => 'required|array|min:1',
            'dppo_qty_produk' => 'required|array|min:1',
            'dppo_harga' => 'required|array|min:1',
        ];
    }

    private function sanitizeNominal($nominal)
    {
        return preg_replace("/[^0-9]/", "", $nominal);
    }

    private function buatTransaksi($userId, $dppoCustomer, $dppoPembayaran)
    {
        $transaksi = new KiosTransaksi();
        $transaksi->employee_id = $userId;
        $transaksi->customer_id = $dppoCustomer;
        $transaksi->metode_pembayaran = $dppoPembayaran;
        $transaksi->ongkir = 0;
        $transaksi->discount = 0;
        $transaksi->tax = 0;
        $transaksi->save();

        return $transaksi;
    }

    private function buatDetailTransaksi($transaksiId, $jenisTransaksi, $produkId, $hargaProduk)
    {
        $detailTransaksi = new KiosTransaksiDetail();
        $detailTransaksi->kios_transaksi_id = $transaksiId;
        $detailTransaksi->jenis_transaksi = $jenisTransaksi;
        $detailTransaksi->kios_produk_id = $produkId;
        $detailTransaksi->serial_number_id = null;

        if ($jenisTransaksi == 'Baru') {
            $dataProduk = KiosProduk::where('sub_jenis_id', $produkId)->first();
            $nilaiPromo = $dataProduk->harga_promo;
            $nilaiSrp = $dataProduk->srp;

            $detailTransaksi->harga_jual = $nilaiSrp;
            $detailTransaksi->harga_promo = $nilaiPromo;
        } else {
            $detailTransaksi->harga_jual = $hargaProduk;
            $detailTransaksi->harga_promo = 0;
        }
        $detailTransaksi->save();
    }

    private function updateStatusTransaksi($transaksi, $status, $nominal, $totalNominal)
    {
        if ($status == 'DP') {
            $transaksi->status_dp = $status;
            KiosTransaksiDPPO::create([
                'kios_transaksi_id' => $transaksi->id,
                'jumlah_pembayaran' => $nominal,
            ]);
        }

        if ($status == 'PO') {
            $transaksi->status_po = $status;

            if ($nominal > 0) {
                $transaksi->status_dp = 'DP';
                KiosTransaksiDPPO::create([
                    'kios_transaksi_id' => $transaksi->id,
                    'jumlah_pembayaran' => $nominal,
                ]);
            }
        }

        $transaksi->total_harga = $totalNominal;
        $transaksi->save();
    }

    public function getSrpProduk($jenisTransaksi, $id)
    {
        if($jenisTransaksi == 'drone_baru') {
            $dataProduk = KiosProduk::where('sub_jenis_id', $id)->first();
            if ($dataProduk->status === 'Promo') {
                $nilai = $dataProduk->harga_promo;
            } else {
                $nilai = $dataProduk->srp;
            }

        } elseif($jenisTransaksi == 'drone_bekas') {
            $nilai = KiosProdukSecond::where('sub_jenis_id', $id)->value('srp');
        }

        return response()->json($nilai);
    }

}
