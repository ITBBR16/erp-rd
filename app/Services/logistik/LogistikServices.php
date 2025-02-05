<?php

namespace App\Services\logistik;

use App\Repositories\umum\UmumRepository;

class LogistikServices
{
    public function __construct(
        private UmumRepository $umum
    ){}
}