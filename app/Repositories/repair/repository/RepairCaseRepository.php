<?php

namespace App\Repositories\repair\repository;

use App\Models\kios\KiosAkunRD;
use App\Models\repair\RepairCase;
use App\Models\repair\RepairJenisCase;
use App\Models\repair\RepairJenisFungsional;
use App\Models\repair\RepairJenisStatus;
use App\Models\repair\RepairKelengkapan;
use App\Models\repair\RepairReqSpareparts;
use App\Models\repair\RepairTransaksi;
use App\Models\repair\RepairTransaksiPembayaran;
use Illuminate\Support\Facades\DB;
use App\Repositories\repair\interface\RepairCaseInterface;

class RepairCaseRepository implements RepairCaseInterface
{
    protected $modelCase, $modelFungsional, $modelJenisCase, $modelRepairKelengkapan, $modelReqPart, $modelStatus, $modelTransaksi, $modelPembayaran, $modelAkun, $connection;

    public function __construct(RepairCase $case, RepairJenisFungsional $repairJenisFungsional, RepairJenisCase $repairJenisCase, RepairKelengkapan $repairKelengkapan, RepairReqSpareparts $repairReqSpareparts, RepairJenisStatus $repairJenisStatus, RepairTransaksi $repairTransaksi, RepairTransaksiPembayaran $repairTransaksiPembayaran, KiosAkunRD $kiosAkunRD)
    {
        $this->modelCase = $case;
        $this->modelFungsional = $repairJenisFungsional;
        $this->modelJenisCase = $repairJenisCase;
        $this->modelRepairKelengkapan = $repairKelengkapan;
        $this->modelReqPart = $repairReqSpareparts;
        $this->modelStatus = $repairJenisStatus;
        $this->modelTransaksi = $repairTransaksi;
        $this->modelPembayaran = $repairTransaksiPembayaran;
        $this->modelAkun = $kiosAkunRD;
        $this->connection = DB::connection('rumahdrone_repair');
    }

    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    public function commitTransaction()
    {
        $this->connection->commit();
    }

    public function rollBackTransaction()
    {
        $this->connection->rollBack();
    }

    // Case Repair
    public function createNewCase(array $data)
    {
        return $this->modelCase->create($data);
    }

    public function findCase($id)
    {
        return $this->modelCase->findOrFail($id);
    }

    public function updateCase($id, array $data)
    {
        $case = $this->modelCase->find($id);
        if ($case) {
            $case->update($data);
            return $case;
        }

        throw new \Exception("Case not found.");
    }

    public function createDetailKelengkapan(array $data)
    {
        return $this->modelRepairKelengkapan->insert($data);
    }

    // CSR Function
    public function createTransaksi(array $data)
    {
        return $this->modelTransaksi->create($data);
    }

    public function updateTransaksi($id, array $data)
    {
        $transaksi = $this->modelTransaksi->find($id);
        if ($transaksi) {
            $transaksi->update($data);
            return $transaksi;
        }

        throw new \Exception("Transaksi not found.");
    }

    public function findTransaksiByCase($caseId)
    {
        return $this->modelTransaksi->where('case_id', $caseId)->first();
    }

    public function createPembayaran(array $data)
    {
        return $this->modelPembayaran->create($data);
    }

    // Get Data Need from Case
    public function getAllDataNeededNewCase()
    {
        return [
            'data_case' => $this->modelCase->all(),
            'jenis_case' => $this->modelJenisCase->all(),
            'fungsional_drone' => $this->modelFungsional->all(),
        ];
    }

    public function getDataRequestPart()
    {
        return $this->modelCase->whereHas('requestPart', function ($query) {
            $query->where('status', 'request');
        })->get();
    }

    public function getDataPenerimaanReqPart()
    {
        return $this->modelCase->whereHas('estimasi', function ($query) {
            $query->whereHas('estimasiPart', function ($sq) {
                $sq->where('active', 'Wait Send Part');
            });
        })
        ->with('estimasi.estimasiPart')
        ->get();
    }

    public function getListReqPart($id)
    {
        return $this->modelReqPart->where('case_id', $id)
                                  ->where('status', 'Request')
                                  ->get();
    }

    public function getNameStatus($id)
    {
        return $this->modelStatus->find($id);
    }

    public function getMetodePembayaran()
    {
        return $this->modelAkun->all();
    }

}
