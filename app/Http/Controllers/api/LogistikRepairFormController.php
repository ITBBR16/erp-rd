<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repositories\logistik\repository\LogistikAPIFormRepairRepository;
use App\Repositories\logistik\repository\LogistikTransactionRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogistikRepairFormController extends Controller
{
    public function __construct(
        private LogistikTransactionRepository $logisticTransaction,
        private LogistikAPIFormRepairRepository $apiFormRepository,
    ){}

    public function storeFromFormGoogleRepair(Request $request)
    {
        try {
            $this->logisticTransaction->beginTransaction();

            $dataPayload = [
                'no_register' => $request->input('no_register'),
                'nama_lengkap' => $request->input('nama_lengkap'),
                'no_wa' => $request->input('no_wa'),
                'email_address' => $request->input('email_address'),
                'provinsi' => $request->input('provinsi'),
                'kabupaten_kota' => $request->input('kabupaten_kota'),
                'kecamatan' => $request->input('kecamatan'),
                'kelurahan' => $request->input('kelurahan'),
                'kode_pos' => $request->input('kode_pos'),
                'alamat' => $request->input('alamat'),
                'tipe_produk' => $request->input('tipe_produk'),
                'fungsional_produk' => $request->input('fungsional_produk'),
                'keluhan' => $request->input('keluhan'),
                'kronologi_kerusakan' => $request->input('kronologi_kerusakan'),
                'penanganan_after_crash' => $request->input('penanganan_after_crash'),
                'riwayat_penggunaan' => $request->input('riwayat_penggunaan'),
                'dokumen_customer' => $request->input('dokumen_customer'),
                'status' => 'Belum Dikirim',
            ];

            $this->apiFormRepository->createDataFormRepair($dataPayload);
            $this->logisticTransaction->commitTransaction();
            return response()->json(['status' => 'success', 'message' => 'Berhasil input data.']);

        } catch (Exception $e) {
            $this->logisticTransaction->rollbackTransaction();
            Log::error('Error in storeFromFormGoogleRepair: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function updateFormForResi(Request $request)
    {
        try {
            $this->logisticTransaction->beginTransaction();

            $no_pendaftaran = $request->input('no_pendaftaran');

            $dataUpdate = [
                'ekspedisi' => $request->input('ekspedisi'),
                'nomor_resi' => $request->input('no_resi'),
                'tanggal_dikirim' => $request->input('timestamp'),
                'status' => 'On Shipping'
            ];

            $this->apiFormRepository->updateDataFormRepair($no_pendaftaran, $dataUpdate);
            $this->logisticTransaction->commitTransaction();
            return response()->json(['status' => 'success', 'message' => 'Berhasil update data.']);

        } catch (Exception $e) {
            $this->logisticTransaction->rollbackTransaction();
            Log::error('Error updateFormForResi: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
