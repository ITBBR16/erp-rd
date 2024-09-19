<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\kios\KiosWTB;
use App\Models\kios\KiosWTS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\kios\KiosDailyRecap;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosRecapKeperluan;
use App\Models\kios\KiosTechnicalSupport;
use App\Models\kios\KiosRecapTechnicalSupport;

class KiosDailyRecapApiController extends Controller
{
    public function createDailyRecap(Request $request)
    {
        try {
            $connectionKios = DB::connection('rumahdrone_kios');
            $connectionKios->beginTransaction();

            $picId = $request->input('employee_id');
            $keperluanRecap = $request->input('keperluan_recap');
            $inputStatus = $request->input('status_produk');
            $keterangan = $request->input('keterangan');

            switch ($keperluanRecap) {
                case 'Want to Buy':
                    $tableKeperluan = KiosWTB::create([
                        'kondisi_produk' => $request->input('kondisi_produk'),
                        'paket_penjualan_id' => $request->input('paket_penjualan'),
                        'keterangan' => $keterangan,
                    ]);
                    $status = in_array($inputStatus, ['Ready', 'Promo']) ? 'Sudah Ditawari Produk' : 'Produk Tidak Tersedia';
                    break;

                case 'Want to Sell':
                    $tableKeperluan = KiosWTS::create([
                        'paket_penjualan_id' => $request->input('paket_penjualan'),
                        'produk_worth' => $request->input('produk_worth'),
                        'keterangan' => $keterangan,
                    ]);
                    $status = $inputStatus == 'Ready' ? 'Produk dibutuhkan' : 'Produk tidak dibutuhkan';
                    break;

                case 'Technical Support':
                    $keperluanTs = KiosTechnicalSupport::findOrFail($request->input('permasalahan'));
                    $tableKeperluan = KiosRecapTechnicalSupport::create([
                        'kategori_permasalahan_id' => $request->input('kategori_permasalahan'),
                        'kios_ts_id' => $request->input('permasalahan'),
                        'jenis_id' => $request->input('jenis_produk'),
                        'keterangan' => $keterangan,
                    ]);
                    $status = $keperluanTs->nama == 'Belum Terdata' ? 'Unprocess' : 'Case Done';
                    break;

                default:
                    $connectionKios->rollBack();
                    return response()->json(['status' => 'Something went wrong.']);
            }

            $today = now()->format('Y-m-d');
            $existingRecap = KiosDailyRecap::where('customer_id', $request->input('nama_customer'))
                ->where('keperluan_id', $request->input('keperluan_recap_id'))
                ->whereDate('created_at', $today)
                ->first();

            if ($existingRecap) {
                $connectionKios->rollBack();
                return response()->json(['status' => 'Data customer dengan keperluan yang sama tidak dapat di input ulang.']);
            }

            $dailyRecap = new KiosDailyRecap([
                'employee_id' => $picId,
                'customer_id' => $request->input('nama_customer'),
                'keperluan_id' => $request->input('keperluan_recap_id'),
                'table_id' => $tableKeperluan->id,
                'status' => $status,
            ]);

            $dailyRecap->save();
            $connectionKios->commit();

            return response()->json(['status' => 'Berhasil membuat daily recap.']);

        } catch (Exception $e) {
            $connectionKios->rollBack();
            return response()->json(['status' => $e->getMessage()]);
        }
    }
}
