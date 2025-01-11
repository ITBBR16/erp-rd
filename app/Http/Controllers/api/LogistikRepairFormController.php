<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repositories\logistik\repository\LogistikAPIFormRepairRepository;
use App\Repositories\logistik\repository\LogistikTransactionRepository;
use Exception;
use Illuminate\Http\Request;

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
                'nama_lengkap' => $request->input('nama_lengkap'),
                'no_wa' => $request->input('no_wa'),
                'email_address' => $request->input('email_address'),
                'provinsi' => $request->input('provinsi'),
                'kabupaten_kota' => $request->input('kabupaten_kota'),
                'kelurahan' => $request->input('kelurahan'),
                'kelurahan' => $request->input('kelurahan'),
                'kode_pos' => $request->input('kode_pos'),
                'alamat' => $request->input('alamat'),
                'tipe_produk' => $request->input('tipe_produk'),
                'fungsional_produk' => $request->input('fungsional_produk'),
                'keluhan' => $request->input('keluhan'),
                'kronologi_kerusakan' => $request->input('kronologi_kerusakan'),
                'penanganan_after_creash' => $request->input('penanganan_after_creash'),
                'riwayat_penggunaan' => $request->input('riwayat_penggunaan'),
                'documen_customer' => $request->input('documen_customer'),
            ];

            $this->apiFormRepository->createDataFormRepair($dataPayload);
            $this->logisticTransaction->commitTransaction();
            return response()->json(['status' => 'success', 'message' => 'Berhasil input data.']);

        } catch (Exception $e) {
            $this->logisticTransaction->rollbackTransaction();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
