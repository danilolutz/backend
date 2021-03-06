<?php

namespace App\Repositories;

use App\Feature;
use App\Repositories\Contracts\Feature as Contract;

class FeatureRepository implements Contract
{
    public function getAllFeatures()
    {
        return Feature::all();
    }

    public function getFeatureById($uuid)
    {
        return Feature::where('uuid', $uuid)->firstOrFail();
    }

    public function createOrUpdate(array $data)
    {
        if (array_has($data, 'uuid')) {
            $feature = Feature::where('uuid', $data['uuid'])->firstOrFail();
            $feature->name = $data['name'];
            $feature->description = $data['description'];
            $feature->enabled = $data['enabled'];
            $feature->save();

            return $feature;
        }

        return Feature::create($data);
    }

    public function toggle($uuid, $activate = true)
    {
        $feature = Feature::where('uuid', $uuid)->firstOrFail();
        $feature->enabled = $activate;

        return $feature->save();
    }
}
