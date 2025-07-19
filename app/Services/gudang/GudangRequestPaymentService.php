<?php

namespace App\Services\gudang;

use App\Repositories\gudang\repository\GudangBelanjaRepository;
use Exception;
use Illuminate\Http\Request;
use App\Repositories\umum\UmumRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\gudang\repository\GudangRequestPaymentRepository;
use App\Repositories\management\repository\AkuntanTransaksiRepository;

class GudangRequestPaymentService
{
    public function __construct(
        private UmumRepository $umum,
        private GudangBelanjaRepository $belanja,
        private GudangRequestPaymentRepository $reqPayment,
        private GudangTransactionRepository $transaction,
        private AkuntanTransaksiRepository $akunBank,
    ) {}

    // Request Payment Index Controller
    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $listDataRP = $this->reqPayment->getDataRequestPayment()->sortByDesc('id');
        $namaAkunBank = $this->akunBank->getNamaBank();
        $listBelanja = $this->belanja->indexBelanja();
        $filterBelanja = $listBelanja->whereIn('status', [
            'Menunggu Konfirmasi Belanja',
            'Menunggu Resi',
            'Waiting Payment',
            'Process Shipping'
        ]);

        return view('gudang.purchasing.reqpayment.payment', [
            'title' => 'Gudang Payment',
            'active' => 'gudang-payment',
            'navActive' => 'purchasing',
            'divisi' => $divisiName,
            'reqPayments' => $listDataRP,
            'namaBank' => $namaAkunBank,
            'filterBelanja' => $filterBelanja,
        ]);
    }

    public function addNewRP(Request $request)
    {
        try {
            $this->transaction->beginTransaction();

            $findBelanja = $this->belanja->findBelanja($request->input('order_id'));
            $nominalOngkir = preg_replace("/[^0-9]/", "", $request->input('nominal_ongkir')) ?: 0;
            $nominalPajak = preg_replace("/[^0-9]/", "", $request->input('nominal_pajak')) ?: 0;
            $jenisTransaksi = '';

            if ($nominalOngkir > 0 && $nominalPajak > 0) {
                $jenisTransaksi = 'Ongkir, Pajak';
            } elseif ($nominalOngkir > 0) {
                $jenisTransaksi = 'Ongkir';
            } elseif ($nominalPajak > 0) {
                $jenisTransaksi = 'Pajak';
            }

            // Update total ongkir dan pajak pada belanja gudang jika nilai nominal tidak kosong
            if ($nominalOngkir > 0) {
                $findBelanja->total_ongkir += $nominalOngkir;
            }

            if ($nominalPajak > 0) {
                $findBelanja->total_pajak += $nominalPajak;
            }

            $dataMetodePembayaran = [
                'nama_bank_id' => $request->input('add_bank_pembayaran'),
                'gudang_supplier_id' => $findBelanja->gudang_supplier_id,
                'media_transaksi' => $request->input('add_media_transaksi'),
                'nama_akun' => $request->input('add_nama_akun'),
                'id_akun' => $request->input('add_id_akun')
            ];

            $metodePembayaran = $this->reqPayment->createOrNotMp(
                [
                    'gudang_supplier_id' => $dataMetodePembayaran['gudang_supplier_id'],
                    'media_transaksi' => $dataMetodePembayaran['media_transaksi']
                ],
                $dataMetodePembayaran
            );

            $totalNominal = $nominalOngkir + $nominalPajak;

            $dataPayment = [
                'gudang_belanja_id' => $findBelanja->id,
                'jenis_transaksi' => $jenisTransaksi,
                'gudang_metode_pembayaran_id' => $metodePembayaran->id,
                'nominal' => $totalNominal,
                'keterangan' => $request->input('keterangan'),
                'status' => 'Waiting Payment',
            ];

            // Mengirim ke bagian akuntan
            $this->reqPayment->createPayment($dataPayment);
            $findBelanja->save();

            $this->transaction->commitTransaction();

            return ['status' => 'success', 'message' => 'Berhasil menambahkan request baru.'];
        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Konfirmasi Pembayaran
    public function konfirmasiIndex()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $listDataRP = $this->reqPayment->getDataRequestPayment()
            ->filter(function ($item) {
                return $item->status == 'Waiting Payment';
            })
            ->sortByDesc('id');

        return view('gudang.purchasing.konfirmasi_pembayaran.konfirmasi-pembayaran', [
            'title' => 'Gudang Konfirmasi Pembayaran',
            'active' => 'gudang-konfirmasi',
            'navActive' => 'purchasing',
            'divisi' => $divisiName,
            'reqPayments' => $listDataRP,
        ]);
    }

    public function konfirmasiUpdate(Request $reqPayment)
    {
        try {
            $this->transaction->beginTransaction();

            $reff = $reqPayment->input('reff_gudang');
            $payment = $this->reqPayment->findPayment($reff);

            if (!$payment) {
                throw new Exception("Request payment not found.");
            }

            $this->reqPayment->updatePayment($payment->id, [
                'status' => 'Done Payment',
            ]);

            $this->belanja->updateBelanja($payment->gudang_belanja_id, [
                'status' => 'Waiting Shipment',
            ]);

            $this->transaction->commitTransaction();

            return [
                'status' => 'success',
                'message' => 'Berhasil mengkonfirmasi pembayaran',
            ];
        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
