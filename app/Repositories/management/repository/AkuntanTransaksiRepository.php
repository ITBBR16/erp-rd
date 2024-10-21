<?php

namespace App\Repositories\management\repository;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\management\AkuntanMutasi;
use App\Models\management\AkuntanTransaksi;
use App\Models\management\AkuntanDaftarAkun;
use App\Models\management\AkuntanDocument;
use App\Models\management\AkuntanDocumentMonth;
use App\Models\management\AkuntanMutasiMonth;
use App\Models\management\AkuntanTransaksiDetail;
use App\Models\repair\RepairEstimasi;
use App\Models\repair\RepairTransaksi;
use App\Repositories\management\interface\AkuntanTransaksiInterface;

class AkuntanTransaksiRepository implements AkuntanTransaksiInterface
{
    protected $connection, $modelAkun, $modelMutasi, $modelMutasiSementara, $ModelTransaksi, $ModelTransaksiDetail, $modelTransaksiRepair, $modelTransaksiKios, $modelDocument, $modelDocumentMonth, $modelEstimasiRepair;

    public function __construct(
        AkuntanDaftarAkun $akuntanDaftarAkun,
        AkuntanDocument $akuntanDocument,
        AkuntanDocumentMonth $akuntanDocumentMonth,
        AkuntanMutasi $akuntanMutasi,
        AkuntanMutasiMonth $akuntanMutasiMonth,
        AkuntanTransaksi $akuntanTransaksi,
        AkuntanTransaksiDetail $akuntanTransaksiDetail,
        RepairTransaksi $repairTransaksi,
        RepairEstimasi $repairEstimasi,
        )
    {
        $this->connection = DB::connection('rumahdrone_management');
        $this->modelAkun = $akuntanDaftarAkun;
        $this->modelDocument = $akuntanDocument;
        $this->modelDocumentMonth = $akuntanDocumentMonth;
        $this->modelMutasi = $akuntanMutasi;
        $this->modelMutasiSementara = $akuntanMutasiMonth;
        $this->ModelTransaksi = $akuntanTransaksi;
        $this->ModelTransaksiDetail = $akuntanTransaksiDetail;
        $this->modelTransaksiRepair = $repairTransaksi;
        $this->modelEstimasiRepair = $repairEstimasi;
    }

    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    public function commitTransaction()
    {
        $this->connection->commit();
    }

    public function rollbackTransaction()
    {
        $this->connection->rollBack();
    }

    // Funtion Input Update
    public function createMutasi(array $data)
    {
        return $this->modelMutasi->create($data);
    }

    public function createTransaksi(array $data)
    {
        return $this->ModelTransaksi->create($data);
    }

    public function createDetailTransaksi(array $data)
    {
        return $this->ModelTransaksiDetail->create($data);
    }
    
    public function createDocument(array $data)
    {
        return $this->modelDocument->create($data);
    }

    public function createMutasiSementara(array $data)
    {
        return $this->modelMutasiSementara->create($data);
    }
    
    public function createDocumentasiSementara(array $data)
    {
        return $this->modelDocumentMonth->create($data);
    }

    public function updateMutasiSementara(array $data, $id)
    {
        $mutasiSementara = $this->modelMutasiSementara->find($id);
        if ($mutasiSementara) {
            $mutasiSementara->update($data);
            return $mutasiSementara;
        }

        throw new \Exception("Mutasi not found.");
    }

    public function updateTransaksiDetail(array $data, $id)
    {
        $mutasiSementara = $this->ModelTransaksiDetail->find($id);
        if ($mutasiSementara) {
            $mutasiSementara->update($data);
            return $mutasiSementara;
        }

        throw new \Exception("Detail transaksi not found.");
    }

    // Function Find
    public function findNamaAkun($id)
    {
        return $this->modelAkun->find($id);
    }

    public function findMutasiMM($id)
    {
        return $this->modelMutasi->with('mergeMutasiTransaksiRepair')->find($id);
    }

    public function findMutasiSementara($id)
    {
        return $this->modelMutasiSementara->find($id);
    }

    public function findeEstimasiRepair($id)
    {
        return $this->modelEstimasiRepair->where('case_id', $id)->first();
    }

    public function findTransaksiNamaAkun($transaksiId, $namaAkun)
    {
        return $this->ModelTransaksiDetail->where('transaksi_id', $transaksiId)
                                          ->where('nama_akun', $namaAkun)
                                          ->first();
    }

    // Funtion Get
    public function getAkunKasir()
    {
        return $this->modelAkun->where('kode_akun', 'like', '111%')->get();
    }

    public function getDataMutasi()
    {
        return $this->modelMutasi->whereDate('created_at', Carbon::today())->get();
    }

    public function getDataMutasiSementara()
    {
        return $this->modelMutasiSementara
                ->whereDate('created_at', Carbon::today())
                ->get();
    }

    public function getDataTransaksi()
    {
        $today = Carbon::today();
        $repairTransaksi = $this->modelTransaksiRepair->selectRaw("CONCAT('R', case_id) as transaksi_id, total_pembayaran, keterangan, status_recap")
                            ->with('mergeMutasiTransaksi')
                            ->whereDate('created_at', $today)
                            ->get();

        return $repairTransaksi;
    }

    public function getSaldoAkhirAkun($akunId)
    {
        $mutasi = $this->modelMutasi->where('akun_id', $akunId)
                                ->orderBy('id', 'desc')
                                ->first();

        if ($mutasi) {
            return $mutasi;
        }

        $akun = $this->modelAkun->find($akunId);
        return $akun ? $akun : null;
    }
}