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

    public function updateBelanja($id, array $belanjaData, array $detailData = [])
    {
        $belanja = $this->gudangBelanja->find($id);

        if (!$belanja) {
            throw new \Exception("List belanja not found.");
        }

        $belanja->update($belanjaData);

        if (!empty($detailData)) {
            $existingDetail = [];

            foreach ($detailData as $item) {
                $detail = $belanja->detailBelanja()->find($item['id']) ?? new $this->gudangBelanjaDetail;
                $detail->fill($item);
                $detail->belanja_id = $belanja->id;
                $detail->save();

                $existingDetail[] = $detail->id;
            }

            $belanja->detailBelanja()->whereNotIn('id', $existingDetail)->delete();
        }

        return $belanja;
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

        throw new \Exception("List belanja not found");
    }

    public function indexBelanja()
    {
        return $this->gudangBelanja->all();
    }

    public function findBelanja($id)
    {
        return $this->gudangBelanja->find($id);
    }
}