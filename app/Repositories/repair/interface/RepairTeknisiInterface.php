<?php

namespace App\Repositories\repair\interface;

interface RepairTeknisiInterface
{
    public function findCase($id);
    public function updateStatusCase($id, array $data);
    public function findTimestime($caseId, $statusId);
    public function createTimestamp(array $data);
    public function addJurnal(array $data);
}