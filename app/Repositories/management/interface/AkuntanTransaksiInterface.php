<?php

namespace App\Repositories\management\interface;

interface AkuntanTransaksiInterface
{
    public function createMutasi(array $data);
    public function createMutasiSementara(array $data);
    public function createDocumentasiSementara(array $data);
    
    public function getAkunKasir();
    public function findNamaAkun($id);
    public function getDataMutasiSementara();
    public function getDataTransaksi();
    public function getSaldoAkhirAkun($akunId);
}