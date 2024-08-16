<?php

namespace App\Repositories\repair\interface;

interface RepairCaseInterface
{
    public function getAllDataNeededNewCase();
    public function findCase($id);

    public function createNewCase(array $data);
    public function updateCase($id, array $data);
    public function createDetailKelengkapan(array $data);
}