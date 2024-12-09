<?php

namespace App\Repositories\repair\repository;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\repair\RepairEstimasi;
use App\Models\repair\RepairEstimasiJRR;
use App\Models\repair\RepairEstimasiChat;
use App\Models\repair\RepairEstimasiPart;
use App\Models\repair\RepairJenisTransaksi;
use App\Models\repair\RepairReqSpareparts;
use App\Repositories\repair\interface\RepairEstimasiInterface;

class RepairEstimasiRepository implements RepairEstimasiInterface
{
    protected $connection;
    public function __construct(
        private RepairEstimasi $modelEstimasi,
        private RepairEstimasiPart $modelEstimasiPart,
        private RepairEstimasiJRR $modelEstimasiJrr,
        private RepairEstimasiChat $modelEstimasiChat,
        private RepairJenisTransaksi $modelJenisTransaksi,
        private RepairReqSpareparts $modelReqPart)
    {
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

    public function rollbackTransaction()
    {
        $this->connection->rollBack();
    }

    public function getJenisTransaksi()
    {
        return $this->modelJenisTransaksi->all();
    }

    public function findEstimasi($id)
    {
        $findEstimasi = $this->modelEstimasi->find($id);
        if ($findEstimasi) {
            return $findEstimasi;
        }

        throw new \Exception('Data Not Found.');
    }

    public function ensureHaveEstimasi($caseId)
    {
        return $this->modelEstimasi->where('case_id', $caseId)->first();
    }
    
    public function createEstimasi(array $data)
    {
        return $this->modelEstimasi->create($data);
    }

    public function updateEstimasi($data, $id)
    {
        $dataEstimasi = $this->modelEstimasi->findOrFail($id);
        if ($dataEstimasi) {
            $dataEstimasi->update($data);
            return $dataEstimasi;
        }

        throw new \Exception('Case Not Found');
    }

    public function createEstimasiChat(array $data)
    {
        return $this->modelEstimasiChat->create($data);
    }

    public function updateEstimasiChat($data, $id)
    {
        $dataChat = $this->modelEstimasiChat->where('estimasi_id', $id)->first();

        if ($dataChat) {
            return $dataChat->update($data);
        }

        throw new \Exception('Data chat not found.');
    }

    public function createEstimasiPart(array $data)
    {
        return $this->modelEstimasiPart->create($data);
    }

    public function updateEstimasiPart($data, $id)
    {
        $dataPart = $this->modelEstimasiPart->find($id);
        if ($dataPart) {
            return $dataPart->update($data);
        }

        throw new \Exception('Data part not found.');
    }

    public function createEstimasiJrr(array $data)
    {
        return $this->modelEstimasiJrr->create($data);
    }

    public function updateEstimasiJrr($data, $id)
    {
        $dataJrr = $this->modelEstimasiJrr->find($id);
        if ($dataJrr) {
            return $dataJrr->update($data);
        }

        throw new \Exception('Data jasa repair not found.');
    }

    public function updateReqPart($data, $id)
    {
        $dataReq = $this->modelReqPart->find($id);
        if ($dataReq) {
            return $dataReq->update($data);
        }

        throw new \Exception('Data request part not found');
    }

}