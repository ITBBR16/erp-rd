<?php

namespace App\Repositories\gudang\repository;

use App\Models\gudang\GudangBelanja;
use App\Models\gudang\GudangBelanjaDetail;
use App\Models\gudang\GudangMetodePembayaran;
use App\Repositories\gudang\interface\GudangBelanjaInterface;

class GudangBelanjaRepository implements GudangBelanjaInterface
{
    public function __construct(
        private GudangBelanja $gudangBelanja,
        private GudangBelanjaDetail $gudangBelanjaDetail,
        private GudangMetodePembayaran $metodePembayaran,
    ){}
    
    public function indexBelanja()
    {
        return $this->gudangBelanja->all();
    }

    public function findBelanja($id)
    {
        return $this->gudangBelanja->find($id);
    }

    public function getDetailBelanja($belanjaId, $sparepartId)
    {
        return $this->gudangBelanjaDetail->where('gudang_belanja_id', $belanjaId)->where('sparepart_id', $sparepartId)->get();
    }

    public function createMetodePembayaran(array $data)
    {
        $metodePembayaran = $this->metodePembayaran->create($data);
        return $metodePembayaran;
    }

    public function createBelanja(array $dataBelanja, array $detailBelanja)
    {
        $belanja = $this->gudangBelanja->create($dataBelanja);

        foreach ($detailBelanja as $item) {
            $belanja->detailBelanja()->create($item);
        }

        return $belanja;
    }

    public function updateBelanja($belanja, array $belanjaData)
    {
        $resultUpdate = $belanja->update($belanjaData);
        return $resultUpdate;
    }

    public function updateBelanjaDetails($belanja, array $detailData)
    {
        $existingDetailIds = [];

        foreach ($detailData as $item) {
            $detail = $belanja->detailBelanja()->find($item['id']) ?? new $this->gudangBelanjaDetail;
            $detail->fill($item);
            $detail->belanja_id = $belanja->id;
            $detail->save();

            $existingDetailIds[] = $detail->id;
        }

        return $existingDetailIds;
    }

    public function updateOrCreateMP(array $attributes, array $values = [])
    {
        $model = $this->metodePembayaran->where($attributes)->first();

        if ($model) {
            $model->update($values);
        } else {
            $model = $this->metodePembayaran->create(array_merge($attributes, $values));
        }

        return $model;
    }

    public function deleteBelanja($id)
    {
        $belanja = $this->gudangBelanja->find($id);
        if ($belanja) {
            $belanja->detailBelanja()->delete();
            $belanja->delete();
            return $belanja;
        }

        throw new \Exception("List belanja not found.");
    }

}