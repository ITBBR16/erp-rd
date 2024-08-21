<?php

namespace App\Services\repair;

use App\Repositories\repair\repository\RepairCaseRepository;
use App\Repositories\repair\repository\RepairEstimasiRepository;

class RepairCaseService
{
    protected $repairCase, $repairEstimasi;

    public function __construct(RepairCaseRepository $repairCaseRepository, RepairEstimasiRepository $repairEstimasiRepository)
    {
        $this->repairCase = $repairCaseRepository;
        $this->repairEstimasi = $repairEstimasiRepository;
    }

    
}