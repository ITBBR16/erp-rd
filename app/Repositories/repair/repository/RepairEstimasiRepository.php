<?php

namespace App\Repositories\repair\repository;

use Carbon\Carbon;
use App\Models\repair\RepairCase;
use Illuminate\Support\Facades\DB;
use App\Models\repair\RepairJurnal;
use App\Models\repair\RepairEstimasi;
use App\Models\repair\RepairEstimasiJRR;
use App\Models\repair\RepairEstimasiChat;
use App\Models\repair\RepairEstimasiPart;
use App\Models\repair\RepairJenisTransaksi;
use App\Models\repair\RepairTimestampStatus;
use App\Repositories\repair\interface\RepairEstimasiInterface;

class RepairEstimasiRepository implements RepairEstimasiInterface
{
    protected $connection, $modelCase, $modelTimestamp, $modelJurnal, $modelEstimasi, $modelEstimasiPart, $modelEstimasiJrr, $modelEstimasiChat, $modelJenisTransaksi;
    public function __construct(RepairCase $repairCase, RepairJurnal $jurnal, RepairTimestampStatus $repairTimestampStatus, RepairEstimasi $repairEstimasi, RepairEstimasiPart $repairEstimasiPart, RepairEstimasiJRR $repairEstimasiJRR, RepairEstimasiChat $repairEstimasiChat, RepairJenisTransaksi $repairJenisTransaksi)
    {
        $this->modelCase = $repairCase;
        $this->modelEstimasi = $repairEstimasi;
        $this->modelEstimasiJrr = $repairEstimasiJRR;
        $this->modelEstimasiPart = $repairEstimasiPart;
        $this->modelEstimasiChat = $repairEstimasiChat;
        $this->modelJenisTransaksi = $repairJenisTransaksi;
        $this->modelTimestamp = $repairTimestampStatus;
        $this->modelJurnal = $jurnal;
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
    
    public function createEstimasi(array $data)
    {
        return $this->modelEstimasi->create($data);
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
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        return $this->modelEstimasiPart->insert($data);
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
        if (isset($data['estimasi_id'])) {
            $data = [$data];
        }
    
        foreach ($data as &$entry) {
            $entry['created_at'] = Carbon::now();
            $entry['updated_at'] = Carbon::now();
        }
    
        return $this->modelEstimasiJrr->insert($data);
    }

    public function updateEstimasiJrr($data, $id)
    {
        $dataJrr = $this->modelEstimasiJrr->find($id);
        if ($dataJrr) {
            return $dataJrr->update($data);
        }

        throw new \Exception('Data jasa repair not found.');
    }

}