<?php

namespace App\Repositories\repair\interface;

interface RepairTimeJurnalInterface
{
    public function createTimestamp(array $data);
    public function findTimestime($caseId, $statusId);
    public function addJurnal(array $data);
}