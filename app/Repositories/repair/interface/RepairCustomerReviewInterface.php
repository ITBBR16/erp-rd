<?php

namespace App\Repositories\repair\interface;

interface RepairCustomerReviewInterface
{
    public function storeReview(array $data);
    public function findReviewByCaseIdAndDate($caseId, $date);
}