<?php

namespace App\Repositories\repair\interface;

interface RepairCaseInterface
{
    public function getAllDataNeededNewCase();
    public function getDataRequestPart();
    public function getDataPenerimaanReqPart();
    public function getListReqPart($id);
    public function findCase($id);

    public function createNewCase(array $data);
    public function updateCase($id, array $data);
    public function updateDetailKelengkapan($caseId, array $data);
    public function createDetailKelengkapan(array $data);
    
    public function createTransaksi(array $data);
    public function findTransaksiByCase($caseId);
    public function createPembayaran(array $data);

}