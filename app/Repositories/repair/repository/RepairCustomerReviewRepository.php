<?php

namespace App\Repositories\repair\repository;

use Illuminate\Support\Facades\DB;
use App\Models\repair\RepairReviewCustomer;
use App\Repositories\repair\interface\RepairCustomerReviewInterface;

class RepairCustomerReviewRepository implements RepairCustomerReviewInterface
{
    protected $modelReview, $connection;

    public function __construct(RepairReviewCustomer $repairReviewCustomer)
    {
        $this->modelReview = $repairReviewCustomer;
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

    public function findReviewByCaseIdAndDate($caseId, $date)
    {
        return $this->modelReview->where('case_id', $caseId)
                            ->whereDate('created_at', $date)
                            ->first();
    }

    public function storeReview(array $data)
    {
        return $this->modelReview->create($data);
    }

}